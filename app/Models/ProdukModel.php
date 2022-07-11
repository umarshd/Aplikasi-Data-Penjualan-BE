<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdukModel extends Model
{
  protected $table = 'produk';
  protected $primaryKey = 'id';
  protected $returnType = 'array';
  protected $allowedFields = [
    'nama',
    'harga',
    'stok',
    'jenis_barang_id',
  ];
}
