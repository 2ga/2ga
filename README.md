TO/GA(2ga)
===
Licence
----------
Copyright &copy; 2012 TO/GA Project (HirotoYahagi, et al.)
Licensed under the [GNU Affero General Public License Version 3][AGPL]  

[AGPL]: http://www.gnu.org/licenses/agpl-3.0.html

Disclaimer
----------
開発者は本システムが利用者の意図通りに動作することを保証しません。プログラムの動作に関してはソースコードを確認し、利用者様ご自身の責任でご利用ください。
本システムをご利用の際は適切なファイアーウオール設定の下ご利用ください。本システムは信頼の置ける利用者のみが利用する環境に設置されることを前提として制作されており、グローバル環境に公開することは想定しておりません。
また、その他の一切の件に関して開発者は利用者が本システムを利用したこと及び利用できなかったとことに起因する一切の損害の責任を負いません。
合わせて本システムは開発版であることを申し伝えます。
＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿＿

インストール方法

1.ダウンロードする
Virtualbox: https://www.virtualbox.org/wiki/Downloads

VMイメージ: http://toga.tom.sfc.keio.ac.jp/toga_dev_vm.vhd

2.Virtualboxのインストール

3.HostOnlyAdapterの設定
   <br> 　　(1. 設定画面<Preferences>の起動
   <br> 　　(2. ネットワーク<Network>を選択
   <br> 　　(3. 追加ボタンをクリック
   <br> 　　(4. 設定を入力
   <br>   　　　-   IPv4  Address   : 192.168.56.1
   <br>   　　　- IPv4 Network Mask : 255.255.255.0

4.仮想マシンのインポート
  <br> 　　(1. 名前<Name>、OSタイプを設定
    <br>　　　　OSType -> Operating System : Linux
    <br>　　　　Version : Red Hat
  <br> 　　(2. メモリの設定
  <br> 　　(3. 既存のディスク<ダウンロードしたVMイメージ>を選択
  <br> 　　(4. 選択した項目に間違いがないことを確認し、作成<create>ボタンをクリック

5.起動準備
  <br> 　　(1. 作成した仮想マシンを選択し、設定<Settings>をクリック
  <br> 　　(2. ネットワーク<Network>をクリックし、Adapter1をクリック
  <br>　　 　　-NIICをNATモード、MACアドレス080027028A6Aで設定
  <br> 　　(3. Adapter2をクリック
  <br> 　　    -NIC2をHostOnlyモード、MACアドレス080027794AB3で設定。Nameは先ほど作ったアダプタ
  <br> 　　(4. 選択した項目に間違いがないことを確認し、完了<OK>ボタンをクリック

6.初回起動＆セットアップ
  <br> 　　(1. VMを選択して起動
  <br> 　　(2. ユーザ名rootのパスワードroot2gaでログイン
  <br> 　　(3. パスワードを変える
  <br> 　　〜パスワード変更方法〜
__________________________________

<br>　# passwd root
<br>Changing password for user root.
<br>New password:   (新しいパスワードを入力)
<br>Retype new password:    (新しいパスワードをもう一度入力)
<br>passwd: all authentication tokens updated successfully. 
<br>
__________________________________
 
  <br> 　　(4. コードをクローン作成
  <br> 　　〜クローン作成方法〜
__________________________________
<br>  # cd /share/toga/
<br># git clone git@github.com:2ga/2ga.git
<br># cd 2ga
<br># git submodule init
<br># git submodule update
__________________________________

  <br> 　　(5. TO/GAファイルを作成
  <br> 　　〜作成方法〜
__________________________________
<br># cp TogaSettings.php.sample TogaSettings.php
<br># emacs TogaSettings.php
 
<br>(ファイルを編集後、保存)
<br>(MySQLの初期設定はroot:4WTFqvShです)
__________________________________

  <br> 　　(6. TOGAのインストール -> Apache再起動
  <br> 　　〜インストール方法〜
__________________________________
<br># cd /share/toga/2ga
<br># ./install
<br># ./symfony doctrine:build --all --and-load
<br># chown -R apache:apache /share/toga/2ga
<br># chown -R apache:apache /share/toga/toga_data
<br># /etc/init.d/httpd restart
__________________________________
<br> 　　
http://conf1.toga-test.comにアクセス出来れば完成。
