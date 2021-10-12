<?php
declare(strict_types=1);

namespace Study\ApiStudy\Model;

class PostManagement {

    /**
     * {@inheritdoc}
     */
    public function getPost($param)
    {
        return 'api GET return the $param ' . $param;
    }
}
