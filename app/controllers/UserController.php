<?php

class UserController extends Controller
{
    public function dashboard(): void
    {
        Middleware::role(['user']);
        $reportModel = $this->model('Report');
        $notificationModel = $this->model('Notification');
        $reports = $reportModel->byUser((int) current_user()['id']);

        $this->view('dashboard/user', [
            'title' => 'Dashboard Masyarakat',
            'reports' => $reports,
            'notifications' => $notificationModel->latestForUser((int) current_user()['id']),
        ]);
    }
}

