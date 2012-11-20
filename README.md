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
  (1. 設定画面<Preferences>の起動
  (2. ネットワーク<Network>を選択
  (3. 追加ボタンをクリック
  (4. 設定を入力
      -   IPv4  Address   : 192.168.56.1
      - IPv4 Network Mask : 255.255.255.0

4.仮想マシンのインポート
  (1. 名前<Name>、OSタイプを設定
    OSType -> Operating System : Linux
                       Version : Red Hat
  (2. メモリの設定
  (3. 既存のディスク<ダウンロードしたVMイメージ>を選択
  (4. 選択した項目に間違いがないことを確認し、作成<create>ボタンをクリック

5.起動準備
  (1. 作成した仮想マシンを選択し、設定<Settings>をクリック
  (2. ネットワーク<Network>をクリックし、Adapter1をクリック
      -NIICをNATモード、MACアドレス080027028A6Aで設定
  (3. Adapter2をクリック
      -NIC2をHostOnlyモード、MACアドレス080027794AB3で設定。Nameは先ほど作ったアダプタ
  (4. 選択した項目に間違いがないことを確認し、完了<OK>ボタンをクリック

6.初回起動＆セットアップ
  (1. VMを選択して起動
  (2. ユーザ名rootのパスワードroot2gaでログイン
  (3. パスワードを変える
  〜パスワード変更方法〜
__________________________________
# passwd root
Changing password for user root.
New password:   (新しいパスワードを入力)
Retype new password:    (新しいパスワードをもう一度入力)
passwd: all authentication tokens updated successfully. 
__________________________________
 
  (4. コードをクローン作成
  〜クローン作成方法〜
__________________________________
  # cd /share/toga/
# git clone git@github.com:2ga/2ga.git
# cd 2ga
# git submodule init
# git submodule update
__________________________________

  (5. TO/GAファイルを作成
  〜作成方法〜
__________________________________
# cp TogaSettings.php.sample TogaSettings.php
# emacs TogaSettings.php
 
(ファイルを編集後、保存)
(MySQLの初期設定はroot:4WTFqvShです)
__________________________________

  (6. TOGAのインストール -> Apache再起動
  〜インストール方法〜
__________________________________
# cd /share/toga/2ga
# ./install
# ./symfony doctrine:build --all --and-load
# chown -R apache:apache /share/toga/2ga
# chown -R apache:apache /share/toga/toga_data
# /etc/init.d/httpd restart
__________________________________

http://conf1.toga-test.comにアクセス出来れば完成。
