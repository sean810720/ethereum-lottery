<p align="center"><h1>Ethereum@Laravel 開發範例 - 樂透遊戲</h1></p>
<p align="center"><img src="https://cdn-images-1.medium.com/max/800/1*m_mZQsA2xauAqBNI8DQx1w.png"></p>
<br/><br/>

## 1. 以太坊私鏈架設

- Ganache 下載連結:<br />
https://truffleframework.com/ganache

- 安裝完啟動後, 到設定內將 port 改為 8545, 儲存 & 重啟程式後則建好一條私鏈:<br />
http://127.0.0.1:8545<br /><br />


## 2. 安裝 Truffle 環境

- 執行以下指令:<br />
npm install -g truffle<br /><br />


## 3. 編譯智慧合約並配置上私鏈

- 在 Laravel 專案根目錄下執行:<br />
cd truffle<br />
truffle migrate --reset<br /><br />


## 4. 安裝必備 composer 套件

- 在專案根目錄下執行:<br />
composer install<br /><br />


## 5. 編輯 .env 檔

- 在專案根目錄下執行:<br />
cp .env.example .env<br />
vi .env<br />

- 在 .env 內編輯以下參數:<br />
ETH_HOST=http://localhost<br />
ETH_PORT=8545<br />
ETH_OWNER_ADDRESS=莊家錢包 Address, 請輸入私鏈上第一個 Account 的錢包 Address<br />
ETH_CONTRACT_ADDRESS=智慧合約錢包 Address, 請輸入第 3. 點部署合約的 Address<br /><br />


## 6. 測試環境 MySQL 設定/匯入

- 先在測試環境的 MySQL 建立一個新資料庫「ethereum_lottery」，並編輯 .env 內「DB_」開頭的參數 <br />

- 接著在專案根目錄下執行:<br />
php artisan migrate:fresh --seed<br /><br />


## 7. 測試看看

- 在 Laravel 專案根目錄下執行:<br />
php artisan serve<br />

- 登入連結:<br />
http://127.0.0.1:8000<br />
玩家先註冊後下注<br />

- 莊家開獎:<br />
登入帳號: admin@lottery.com<br />
登入密碼: 123456<br />
按下「開獎」即可<br /><br />


## 相關連結

- Truffle 用法<br />
https://truffleframework.com/docs<br />

- 以太坊 RPC API 文件<br />
https://github.com/ethereum/wiki/wiki/JSON-RPC

- Ethereum Package for Laravel<br />
https://github.com/jcsofts/laravel-ethereum/blob/master/README.md<br />



