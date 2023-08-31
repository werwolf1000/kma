<?php

namespace models;

use vendor\Model;

class KmaTaskModel extends Model
{
    protected static string $table = 'tasks';
    public int $id;
    public string $urls;
    public string $created_at;
    public string $updated_at;
    public string $deleted_at;

}