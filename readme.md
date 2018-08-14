<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>
<p align="center"><img height="200" src="https://img.jinse.com/139170_image3.png"></p>
<p align="center"><h1>Ethereum@Laravel 開發範例 - 樂透遊戲</h1></p><br /><br />

## 1. 安裝必備 composer 套件

- 在專案根目錄下執行:<br />
composer install<br /><br />


## 2. 編輯 .env 檔

- 在專案根目錄下執行:<br />
cp .env.example .env

- 編輯 .env<br />
vi .env

- 加入以下內容:<br />
ETH_HOST='http://localhost'<br />
ETH_PORT=8545<br /><br />

## 4. 測試環境 MySQL 設定/匯入

- 先在本機環境建一個新的資料庫「lottery」，相關設定則編輯 .env 內容的 DB_ 開頭屬性 <br />

- 在專案根目錄下執行:<br />
php artisan migrate<br /><br />


## 3. 以太坊私鏈架設

- Ganache 下載連結:<br />
https://truffleframework.com/ganache

- 安裝完啟動後本機就會預設有一條私鏈:<br />
http://127.0.0.1:8545<br /><br />


## 4. 安裝 Truffle 環境

- 執行以下指令:<br />
npm install -g truffle<br /><br />


## 5. 編譯智慧合約並配置上私鏈

- 在 Laravel 專案根目錄下執行:<br />
cd truffle<br />
truffle compile<br />
truffle migrate --reset<br /><br />

## 6. 修改 LotteryController.php

- 調整 app/Http/Controllers/LotteryController.php 中的「呼叫者錢包位址」與「被呼叫的合約或錢包位址」<br /><br />

## 7. 修改 HomeController.php

- 調整 app/Http/Controllers/HomeController.php 中的「被呼叫的合約或錢包位址」<br /><br />

## 8. 測試看看

- 在 Laravel 專案根目錄下執行:<br />
php artisan serve<br />

- 玩家連結:<br />
http://127.0.0.1:8000<br />
先註冊後下注<br />

- 莊家開獎連結:<br />
http://127.0.0.1:8000/pick_winner<br /><br />

## 相關連結

- Truffle 用法<br />
https://truffleframework.com/docs<br />

- 以太坊 RPC API 文件<br />
https://github.com/ethereum/wiki/wiki/JSON-RPC

- Ethereum Package for Laravel<br />
https://github.com/jcsofts/laravel-ethereum/blob/master/README.md<br />



