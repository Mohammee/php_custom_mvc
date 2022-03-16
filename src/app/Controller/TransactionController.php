<?php

declare(strict_types=1);

namespace App\Controller;


use App\Exception\UnauthenticationException;
use App\Model\Transaction;
use App\View;

class TransactionController
{

    public function index()
    {
        if (!isset($_SESSION['AUTH_USER'])) {
            throw new UnauthenticationException();
        }

        $transactions = (new Transaction())->get();

       $data = ($this->customTransaction($transactions));


        return View::make('transaction/index', compact('data'));
    }

    private function customTransaction(array $transactions): array
    {
        $income = 0;
        $expense = 0;
        foreach($transactions as &$transaction){
            if($transaction['amount'] > 0){
                $income += (float)$transaction['amount'];
                $transaction['class'] = 'red';
                $transaction['amount'] = '$' . $transaction['amount'];
            }else{
                $expense += (float)$transaction['amount'];
                $transaction['class'] = 'green';
                $transaction['amount'] = '-$' . abs((float)$transaction['amount']);
            }
            $transaction['date'] = date('M m, Y', strtotime($transaction['date']));

        }

        $total = $income + $expense;
        return [
            'transactions' => $transactions,
            'income' => '$' . $income,
            'expense' => '-$' . abs($expense),
            'total' => $total > 0 ? '$' . $total: '-$' . abs($total)
        ];
    }

    private function getTransactions(): array
    {
        $transactions = [];

        $dir = __CSV_PATH__;

        foreach ($this->getTransactionFiles($dir) as $file) {
            $transactions[] = $this->getTransactionFileContent($file);
        }

        return $transactions;
    }

    public function getTransactionFileContent(string $file, ?callable $transactionHandler = null): array
    {
        $transactions = [];

        if (!file_exists($file)) {
            trigger_error('File Not Found!', E_USER_ERROR);
        }

        $file = fopen($file, 'r');
        fgetcsv($file);

        while (($transaction = fgetcsv($file)) !== false) {
            $transactions[] = isset($transactionHandler) ?
                $transactionHandler($transaction) : $this->extractTransaction($transaction);
        }

        return $transactions;
    }

    public function getTransactionFiles(string $dir_path): array
    {
        $files = [];

        foreach (scandir($dir_path) as $file) {
            if ($file === '.' || $file === '..') {
                continue;
            }

            $file = $dir_path.'/'.$file;

            if (is_dir($file)) {
                $files = array_merge($files, $this->getTransactionFiles($file));
                continue;
            }

            $files[] = $file;
        }

        return $files;
    }

    private function extractTransaction(array $transaction): array
    {
        [$date, $check, $description, $amount] = $transaction;

        return [
            'check' => $check,
            'description' => $description,
            'amount' => (float)str_replace(['$', ','], '', $amount),
            'date' => date('Y-m-d H:i:s', strtotime($date)),
        ];
    }
}