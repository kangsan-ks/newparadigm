<?php
namespace App\Classes;
use DB;
use App\Classes\jsonRPCClient;

class TransactionUpdate
{
	var $username	= '';
	var $password	= '';
	var $host		= '';
	var $port		= '';

	var $txid		= '';
	var $address	= '';
	var $category	= '';
	var $send_ok	= '';
	var $coin_type	= '';

	public function __construct($txid = null) {
		if ($txid){
			$transactionsInfo = DB::table('transactions')
								->select(DB::raw('transactions.coin_type as coin_type, transactions.send_ok as send_ok, transactions.category as category, transactions.address as address, transactions.txid as txid'))
								->where('transactions.txid', $txid)
								->get()->first();
			//return $query;
			$this->txid			= $transactionsInfo->txid;
			$this->address		= $transactionsInfo->address;
			$this->category		= $transactionsInfo->category;
			$this->send_ok		= $transactionsInfo->send_ok;
			$this->coin_type	= $transactionsInfo->coin_type;
			$this->check(array(), true);
		}
	}	
	
	public function check(array $row, $condition = false){
		$txid		= $condition == true ? $this->txid : $row['txid'];
		$address	= $condition == true ? $this->address : $row['address'];
		$category	= $condition == true ? $this->category : $row['category']; // send, receive
		$send_ok	= $condition == true ? $this->send_ok : $row['send_ok']; // 1인경우 update 된것 null 인경우 미처리 항목
		$coin_type	= $condition == true ? $this->coin_type : $row['coin_type'];

		$findme   = 'inner';
		$pos = strpos($txid, $findme);
		if ($pos !== false) {
			return;
		}
			
		$returnVal = $this->update($txid, $coin_type, $send_ok, $address, $category);
		return $returnVal;
		
	}

	protected function update($txid, $coin_type, $send_ok, $address, $category){
		$coin_list = DB::table('currency')
					->join('rpcset', 'currency.id', '=', 'rpcset.currency')
					->where('currency.enable', 'Y')
					->where('currency.type', 'B')
					->where('currency.id', $coin_type)
					->get()->first();
		$client = new jsonRPCClient('http://'.$coin_list->username.':'.$coin_list->password.'@'.$coin_list->host.':'.$coin_list->port.'/');
		$result = $client->gettransaction($txid);
		
		if ($result != 'rpcerror'){
			$blockhash		= $result['message']['blockhash'];
			$blockindex		= $result['message']['blockindex'];
			$confirmations	= $result['message']['confirmations'];
			$blocktime		= $result['message']['blocktime'];
			$amount			= $result['message']['amount'];
			$send_data		= $send_ok == '1' ? '1' : 'null';
			if ($send_ok != '1'){
				DB::table('wallet')->where('currency_address', $address)->update(
					[
						'currency_balance' => DB::raw('currency_balance + ' . $result['message']['amount']),
					]
				);
				
				DB::table('transactions')->where('txid', $txid)->update(
					[
						'send_ok' => '1',
					]
				);
				
			}
			
			DB::table('transactions')->where('txid', $txid)->where('category', $category)->update(
				[
					'blockhash' => $blockhash,
					'blockindex' => $blockindex,
					'confirmations' => $confirmations,
					'blocktime' => $blocktime,
					//'send_ok' => $send_data,
				]
			);
			return;
		} else {
			return;
		}
		
		
	}

	
}