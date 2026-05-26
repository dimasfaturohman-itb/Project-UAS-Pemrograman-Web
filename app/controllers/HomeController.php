<?php

class HomeController extends Controller
{
    public function index(): void
    {
        $reportModel = $this->model('Report');
        $categoryModel = $this->model('Category');
        $this->view('home/index', [
            'title' => APP_NAME,
            'stats' => $reportModel->stats(),
            'categories' => $categoryModel->all(),
        ]);
    }
}

