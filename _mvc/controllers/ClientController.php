<?php
namespace App\Controllers;

use App\Models\Client;
use App\Providers\View;
use App\Providers\Validator;

class ClientController {
    public function index() {
        $client = new Client();
        $clients = $client->select();
        View::render('client/index', ['clients' => $clients]);
    }

    public function create() {
        View::render('client/create');
    }

    public function show($data = []) {
        if (isset($data['id']) && $data['id'] != null) {
            $client = new Client();
            $clientData = $client->selectId($data['id']);
            if ($clientData) {
                return View::render('client/show', ['client' => $clientData]);
            } else {
                return View::render('error', ['msg' => 'Client not found!']);
            }
        } else {
            return View::render('error', ['msg' => 'Client ID not provided!']);
        }
    }

    public function edit($data = []) {
        if (isset($data['id']) && $data['id'] != null) {
            $client = new Client();
            $clientData = $client->selectId($data['id']);
            if ($clientData) {
                return View::render('client/edit', ['client' => $clientData]);
            } else {
                return View::render('error', ['msg' => 'Client not found!']);
            }
        } else {
            return View::render('error', ['msg' => 'Client ID not provided!']);
        }
    }

    public function store($data = []) {
        $validator = new Validator();
        $validator->field('name', $data['name'])->min(3)->max(100);
        $validator->field('surname', $data['surname'])->min(3)->max(100);
        $validator->field('email', $data['email'])->required()->email()->max(100);
        $validator->field('phone', $data['phone'])->required()->max(20);

        if ($validator->isSuccess()) {
            $client = new Client();
            $insert = $client->insert($data);
            if ($insert) {
                return View::redirect('client/show?id=' . $insert);
            } else {
                return View::render('error');
            }
        } else {
            $errors = $validator->getErrors();
            return View::render('client/create', ['errors' => $errors, 'client' => $data]);
        }
    }

    public function update($data, $get_data) {
        if (isset($get_data['id']) && $get_data['id'] != null) {
            $id = $get_data['id'];
            $validator = new Validator();
            $validator->field('name', $data['name'])->min(3)->max(100);
            $validator->field('surname', $data['surname'])->min(3)->max(100);
            $validator->field('email', $data['email'])->required()->email()->max(100);
            $validator->field('phone', $data['phone'])->required()->max(20);

            if ($validator->isSuccess()) {
                $client = new Client();
                $update = $client->update($data, $id);
                if ($update) {
                    return View::redirect('client/show?id=' . $id);
                } else {
                    return View::render('error');
                }
            } else {
                $errors = $validator->getErrors();
                return View::render('client/edit', ['errors' => $errors, 'client' => $data]);
            }
        } else {
            return View::render('error', ['msg' => 'Client ID not provided!']);
        }
    }

    public function delete($data) {
        if (isset($data['id']) && $data['id'] != null) {
            $client = new Client();
            $delete = $client->delete($data['id']);
            if ($delete) {
                return View::redirect('client');
            } else {
                return View::render('error');
            }
        } else {
            return View::render('error', ['msg' => 'Client ID not provided!']);
        }
    }
}


?>