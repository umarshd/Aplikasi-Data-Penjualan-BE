<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\ProdukModel;

class Produks extends ResourceController
{
  use ResponseTrait;

  protected $ProdukModel;
  protected $format = 'json';

  public function __construct()
  {
    $this->ProdukModel = new ProdukModel();
    $this->validation = \Config\Services::validation();
  }

  public function index()
  {
    $data = $this->ProdukModel->findAll();
    return $this->respond($data, 200);
  }
  public function show($id = null)
  {
    $data = $this->ProdukModel->where('id', $id)->first();
    if (!$data) {
      return $this->failNotFound('Data Not found');
    }

    return $this->respond($data);
  }

  public function create()
  {
    // $data = $this->request->getPost();
    $data = [
      'nama' => $this->request->getVar('nama'),
      'harga' => $this->request->getVar('harga'),
      'stok' => $this->request->getVar('stok'),
      'jenis_barang_id' => $this->request->getVar('jenis_barang_id')
    ];
    $validate = $this->validation->run($data, 'createProduct');
    $errors = $this->validation->getErrors();

    if ($errors) {
      return $this->fail($errors);
    }

    $this->ProdukModel->insert($data);
    $response = [
      'status' => 201,
      'error' => null,
      'messages'  => [
        'success' => 'Data berhasil disimpan',
        'data' => $data
      ]

    ];

    return $this->respondCreated($response);
  }

  public function update($id = null)
  {
    $json = $this->request->getJSON();
    if ($json) {
      $data = [
        'nama' => $this->$json->nama
      ];
    } else {
      $input = $this->request->getRawInput();
      $data = [
        'nama' => $input['nama']
      ];
    }

    $this->JenisBarangModel->update($id, $data);
    $response = [
      'status' => 200,
      'error' => null,
      'messages' => [
        'success' => 'Data  updated'
      ]
    ];
    $this->respond($response);
  }

  public function delete($id = null)
  {
    $data = $this->JenisBarangModel->find($id);
    if ($data) {
      $this->JenisBarangModel->delete($id);
      $response = [
        'ststus' => 200,
        'error' => null,
        'messages' => [
          'success' => 'Data Deleted'
        ]
      ];
      return $this->respondDeleted($response);
    } else {
      return $this->failNotFound('tidak ditemukan data dengan Id:' . $id);
    }
  }
}
