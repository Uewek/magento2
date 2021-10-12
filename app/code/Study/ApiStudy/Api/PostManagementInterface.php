<?php
declare(strict_types=1);

namespace Study\ApiStudy\Api;

interface PostManagementInterface {


    /**
     * GET for Post api
     * @param string $param
     * @return string
     */

    public function getPost($param);
}
