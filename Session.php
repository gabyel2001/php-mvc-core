<?php

namespace theworker\phpmvc;

/**
 * Class Session
 *
 * @category
 * @package theworker\phpmvc
 * @author gabriel.berza
 */
class Session
{
    /**
     *
     */
    protected const FLASH_KEY = 'flash_messages';

    /**
     *
     */
    public function __construct()
    {
        session_start();
        $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];
        foreach ($flashMessages as &$flashMessage) {
            //Mark to be removed
            $flashMessage['remove'] = true;
        }

        $_SESSION[self::FLASH_KEY] = $flashMessages;
    }

    /**
     * @param string|int $key
     * @param string $message
     */
    public function setFlash(string|int $key, string $message): void
    {
        $_SESSION[self::FLASH_KEY][$key] = [
            'remove' => false,
            'value' => $message
        ];
    }

    /**
     * @param string|int $key
     * @return mixed
     */
    public function getFlash(string|int $key): mixed
    {
        return $_SESSION[self::FLASH_KEY][$key]['value'] ?? false;
    }

    /**
     *
     */
    public function __destruct()
    {
        //Iterate over marked to remove flash messages
        $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];
        foreach ($flashMessages as $key => $flashMessage) {
            if ($flashMessage['remove'] === true) {
                unset($flashMessages[$key]);
            }
        }

        $_SESSION[self::FLASH_KEY] = $flashMessages;
    }

    /**
     * @param string $userClass
     */
    public function setUserClass(string $userClass): void
    {
        $_SESSION['userClass'] = $userClass;
    }

    /**
     * @return string
     */
    public function getUserClass(): string
    {
        return $_SESSION['userClass'] ?? false;
    }

    /**
     * @param string $key
     * @param mixed $value
     */
    public function set(string $key, mixed $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function get(string $key): mixed
    {
        return $_SESSION[$key] ?? false;
    }

    /**
     * @param string $key
     */
    public function remove(string $key): void
    {
        unset($_SESSION[$key]);
    }

}