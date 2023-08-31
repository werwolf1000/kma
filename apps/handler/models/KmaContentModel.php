<?php

namespace models;

use vendor\Model;

class KmaContentModel extends Model
{
    protected static string $table = 'content';
    public int $id;
    public string $urls;
    public int $content;
    public string $created_at;
    public string $updated_at;
    public string $deleted_at;

    /**
     * @param  string  $url
     * @return $this
     */
    public function setUrls(string $url): static
    {
        $this->urls = $url;
        return $this;
    }

    /**
     * @param  int  $length
     * @return $this
     */
    public function setLength(int $length): static
    {
        $this->content = $length;
        return $this;
    }
}