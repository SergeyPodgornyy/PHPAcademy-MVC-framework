<?php

namespace Controller;

class Cast extends Base
{
    public function index()
    {
        $data = $this->app->params();

        $this->run(function () use ($data) {
            return $this->action('Service\Cast\Index')->run($data);
        });
    }

    public function show($id)
    {
        $data = $this->app->params();
        $data['Id'] = $id;

        $this->run(function () use ($data) {
            return $this->action('Service\Cast\Show')->run($data);
        });
    }

    public function create()
    {
        $data = $this->app->params();

        $this->run(function () use ($data) {
            return $this->action('Service\Cast\Create')->run($data);
        });
    }

    public function update($id)
    {
        $data = $this->app->params();
        $data['Id'] = $id;

        $this->run(function () use ($data) {
            return $this->action('Service\Cast\Update')->run($data);
        });
    }

    public function delete($id)
    {
        $data['Id'] = $id;

        $this->run(function () use ($data) {
            return $this->action('Service\Cast\Delete')->run($data);
        });
    }
}
