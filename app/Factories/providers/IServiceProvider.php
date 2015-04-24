<?php
/**
 * Created by PhpStorm.
 * User: helenpham
 * Date: 11/6/14
 * Time: 15:20
 */

namespace App\Factories\providers;

interface IServiceProvider {
    /**
     * @return  IServiceProvider  service instance
     */
    public static function getInstance();

    public function getServiceInstance();
} 