<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\JenisBarangModel;

class JenisBarang extends ResourceController
{
  use ResponseTrait;
  protected $format = 'json';
  protected $JenisBarangModel;
  public function __construct()
  {
    $this->JenisBarangModel = new JenisBarangModel();
  }

  public function index()
  {
    $data = $this->JenisBarangModel->findAll();
    return $this->respond($data, 200);
  }

  public function show($id = null)
  {
    $data = $this->JenisBarangModel->where('id', $id)->first();
    if (!$data) {
      return $this->failNotFound('Data Not found');
    }

    return $this->respond($data);
  }

  public function create()
  {
    $data = [
      'nama' => $this->request->getVar('nama'),
    ];

    $this->JenisBarangModel->insert($data);
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
      return $this->failNotFound('tidak ditemukan data dengan Id: ', $id);
    }
  }
}
