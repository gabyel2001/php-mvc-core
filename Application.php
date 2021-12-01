<?php

namespace theworker\phpmvc;

use theworker\phpmvc\db\Database;

/**
 * Class Application
 *
 * @category
 * @package theworker\phpmvc
 * @author gabriel.berza
 */
class Application
{
    const EVENT_BEFORE_REQUEST = 'beforeRequest';
    const EVENT_AFTER_REQUEST = 'afterRequest';

    protected array $eventListeners = [];

    public string $layout = 'main';
    public static string $ROOT_DIR;
    public Router $router;
    public Request $request;
    public Response $response;
    public Session $session;
    public Database $db;
    public static Application $app;
    public ?Controller $controller = null;
    public ?UserModel $user = null;
    public View $view;

    public function __construct(string $rootPath, array $config)
    {
        self::$ROOT_DIR = $rootPath;
        self::$app = $this;
        $this->request = new Request();
        $this->response = new Response();
        $this->session = new Session();
        $this->router = new Router($this->request, $this->response);
        $this->db = new Database($config['db']);
        $this->view = new View();
        //get user by session id
        $userClassName = $this->session->getUserClass();
        $userClass = $this->getInstanceByClassName($userClassName);
        $primaryValue = $this->session->get('user');
        if ($primaryValue && $userClass) {
            $primaryKey = $userClass->primaryKey();
            $this->user = $userClass->findOne([$primaryKey => $primaryValue]);
        }
    }

    public function getInstanceByClassName(string $className)
    {
        return class_exists($className) ? new $className() : false;
    }

    public function getResponse()
    {
        return $this->response;
    }

    public function run()
    {
        $this->triggerEvent(self::EVENT_BEFORE_REQUEST);
        try {
            echo $this->router->resolve();
        } catch (\Exception $e) {
            $this->response->setStatusCode($e->getCode());
            echo $this->view->renderView('_error', ['exception' => $e]);
        }
    }

    public function triggerEvent($eventName)
    {
        $callbacks = $this->eventListeners[$eventName] ?? false;
        foreach ($callbacks as $callback){
            call_user_func($callback);
        }
    }

    public function on($eventName, $callback)
    {
        $this->eventListeners[$eventName][] = $callback;
    }

    /**
     * @return Controller
     */
    public function getController(): Controller
    {
        return $this->controller;
    }

    /**
     * @param Controller $controller
     */
    public function setController(Controller $controller): void
    {
        $this->controller = $controller;
    }

    public function login(UserModel $user)
    {
        $this->session->setUserClass($user::class ?? false);
        $this->user = $user;
        $primaryKey = $user->primaryKey();
        $primaryValue = $user->{$primaryKey};
        $this->session->set('user', $primaryValue);
        return true;
    }

    public function logout()
    {
        $this->user = null;
        $this->session->remove('user');
        $this->session->remove('userClass');
    }

    public static function isGuest()
    {
        return !self::$app->user;
    }
}