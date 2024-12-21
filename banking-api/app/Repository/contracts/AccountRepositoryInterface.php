<?php

namespace App\Repository\contracts;

interface AccountRepositoryInterface
{
     /**
     * Cria uma nova conta.
     *
     * @param array $data
     * @return mixed
     */

     public function create(array $data);


     /**
     * Busca uma conta pelo número.
     *
     * @param int $number_account
     * @return mixed
     */
    public function findByNumber(int $number_account);
}
