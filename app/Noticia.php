<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Noticia extends Model
{
    use SoftDeletes;

    protected $table = 'noticia';
    public $timestamps = true;
    protected $dates = ['deleted_at'];
    protected $guarded = ['id',"deleted_at","created_at","updated_at"];
//    protected $with = ['categoria'];

    public function categoria()
    {
        return $this->hasOne('App\Categoria', 'id', 'categoria_id')
            ->select([
                'id',
                'nombre',
                'descripcion'
            ]);
    }

    public function imagenes()
    {
        return $this->hasMany('App\NoticiaImagen', 'noticia_id', 'id')
            ->select([
                'id',
                'url',
                'noticia_id',
            ]);
    }
}
