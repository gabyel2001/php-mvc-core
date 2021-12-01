<?php

namespace theworker\phpmvc\form;

use theworker\phpmvc\Model;

/**
 * Class BaseField
 *
 * @category
 * @package theworker\phpmvc\form
 * @author gabriel.berza
 */
abstract class BaseField
{

    public string $attribute;
    public Model $model;

    abstract public function renderInput(): string;


    /**
     * @param Model $model
     * @param string $attribute
     */
    public function __construct(Model $model, string $attribute)
    {
        $this->model = $model;
        $this->attribute = $attribute;
    }

    public function __toString(): string
    {
        return sprintf('
            <div class="mb-3">
                <label>%s</label>
                %s
                <div class="invalid-feedback">
                        %s
                </div>
            </div>
        ',
            $this->model->getLabel($this->attribute),
            $this->renderInput(),
            $this->model->getFirstError($this->attribute));
    }

}