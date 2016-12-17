<?php

namespace Controller;

class Dashboard extends Base
{
    public function index()
    {
        $params = $this->app->params();
        echo 'index';
    }

    public function show($id)
    {
        echo 'show ', $id;
    }

    public function create()
    {
        echo 'create';
    }

    public function update($id)
    {
        echo 'update ', $id;
    }

    public function delete($id)
    {
        echo 'delete ', $id;
    }
}
