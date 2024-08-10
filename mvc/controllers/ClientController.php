<?php
namespace App\Controllers;

use App\Models\Client;
use App\Providers\View;
use App\Providers\Validator;

class ClientController {
    public function index() {
        $client = new Client;
        $clients = $client->select();
        View::render('client/index', ['clients' => $clients]);
    }

    public function create() {
        View::render('client/create');
    }

    public function show($data = []) {
        if (isset($_GET['id']) && !empty($data['id'])) {
            $client = new Client;
            $clientData = $client->selectId($data['id']);
            if ($clientData) {
                View::render('client/show', ['client' => $clientData]);
            } else {
                View::render('client/error', ['msg' => 'Client not found!']);
            }
        } else {
            View::render('client/error', ['msg' => 'Client not found!']);
        }
    }

    public function edit($data = []) {
        if (isset($_GET['id']) && !empty($data['id'])) {
            $client = new Client;
            $clientData = $client->selectId($data['id']);
            if ($clientData) {
                View::render('client/edit', ['client' => $clientData]);
            } else {
                View::render('client/error', ['msg' => 'Client not found!']);
            }
        } else {
            View::render('client/error', ['msg' => 'Client not found!']);
        }
    }

    public function store($data = []) {
        $validator = new Validator;
        $validator->field('name', $data['name'])->min(3)->max(45);
        $validator->field('address', $data['address'])->max(45);
        $validator->field('phone', $data['phone'])->max(20);
        $validator->field('zip_code', $data['zip_code'], 'zip code')->max(10);
        $validator->field('email', $data['email'])->required()->email()->max(45);

        if ($validator->isSuccess()) {
            $client = new Client;
            $insertId = $client->insert($data);
            if ($insertId) {
                View::redirect('client/show?id=' . $insertId);
            } else {
                View::render('client/error');
            }
        } else {
            $errors = $validator->getErrors();
            View::render('client/create', ['errors' => $errors, 'client' => $data]);
        }
    }

    public function update($data, $get_data) {
        if (isset($get_data['id']) && !empty($get_data['id'])) {
            $validator = new Validator;
            $validator->field('name', $data['name'])->min(3)->max(45);
            $validator->field('address', $data['address'])->max(45);
            $validator->field('phone', $data['phone'])->max(20);
            $validator->field('zip_code', $data['zip_code'], 'zip code')->max(10);
            $validator->field('email', $data['email'])->required()->email()->max(45);

            if ($validator->isSuccess()) {
                $client = new Client;
                $update = $client->update($data, $get_data['id']);
                if ($update) {
                    View::redirect('client/show?id=' . $get_data['id']);
                } else {
                    View::render('client/error');
                }
            } else {
                $errors = $validator->getErrors();
                View::render('client/edit', ['errors' => $errors, 'client' => $data]);
            }
        } else {
            View::render('client/error');
        }
    }

    public function delete($data) {
        $client = new Client;
        $delete = $client->delete($data['id']);
        if ($delete) {
            View::redirect('client');
        } else {
            View::render('client/error');
        }
    }
}
?>
