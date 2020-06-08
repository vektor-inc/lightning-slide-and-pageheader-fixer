
// Lightning のヘッダー固定処理JSを停止するためにbodyに対して識別用class付与 ///////////////////////
/*
JPNSTYLEはスライドやページヘッダー部分が固定の特殊処理をしている。
Lightning標準で body に headfix classが付くことによって動作するが、headfixごと削除してしまうと
headfixクラスがある前提のものがあれば影響がでてしまうためheadfixの削除ではなくjpnstyleを付与している
このクラス名によってLightning本体の header_fix.js 内で標準機能が停止される。
*/
document.addEventListener('DOMContentLoaded', function () {
	let bodyClass = document.querySelectorAll("body")[0].getAttribute('class');
	bodyClass = bodyClass.concat(' jpnstyle');
	document.querySelectorAll("body")[0].setAttribute('class', bodyClass );
});
/*----------------------------------------------------------*/
/*	トップページ スライド パララックスに対する背景固定処理 & スライドの次のメインコンテンツへの上部余白追加
/*----------------------------------------------------------*/
;(function($,document,window){

	// トップページ以外では動作させない
	// → ショートコードなどで埋め込めるようになったのでコメントアウト
	// if ( ! $('body').hasClass('home') ){ return }

	// ※ 実際には画像を読み込んだ後で実行される関数だが、
	// この関数だけ先に読み込んでいないと、bild処理などにおいて、
	// 関数を読み込むより先に画像読み込みが完了してしまい、実行しようろした関数はまだ読み込んでいない事が原因で
	// うまく実行されない事があるため
	// document).ready(function(){ などに入れずに読み込んでいる

	function offset_top_slide(){

		// ヘッダー部分の高さを取得
		var headerHeight = $('.siteHeader').height();

		// スライド部分の高さを取得
		var slideHeight = 0;
		// 固定させる要素があるかどうか
		var isFixElementExist = true;

		if ( $('.slide').hasClass('carousel') ){

			// 標準スライダーの場合
			var slideHeight = $('#top__fullcarousel .carousel-inner').height();
			var targetElement = $('#top__fullcarousel');

		} else if ( $('.slide').hasClass('swiper-container') ){
			// Advanced Sliderの場合
			var slideHeight = $('.swiper-container .swiper-wrapper').height();
			var targetElement = $('.swiper-container');

		} else if ( $('.siteHeader').next().hasClass('vkvu')){
			// Video Unitの場合
			var slideHeight = $('.vkvu').height();
			var targetElement = $('.vkvu');

		} else {

			// その他のページの場合
			var slideHeight = $('.page-header').height();
			var targetElement = $('.page-header');

			// const siteHeader = document.getElementsByClassName('siteHeader');
			// const firstElement = siteHeader.nextElementSibling;
			// if( firstElement.classList.contains('siteContent') ){
			//		isFixElementExist = false;
			// }
			if ( $('.siteHeader').next().hasClass('siteContent') ) {
				
				isFixElementExist = false;

			}
		}

		// 管理バーの高さ
		var adminBarHeight = 0;

		// 管理バーが表示されている時
		if ( $('body').hasClass('admin-bar') ){
			// Get adminbar height
			adminBarHeight = $('#wpadminbar').height();
		}

		// スライドやページヘッダーなど固定させる要素がある場合
		if ( isFixElementExist ){

		// Lightingデフォルトの処理 offset_header でも同様に margin-top をつけてくるが
		// offset_header を切られている事もあるので、こちらでもスライド上部に余白をつける処理を再度指定している。
		// ちなみにブラウザ&実行タイミングによっては、このファイルから margin-top を指定しても、
		// Lightning標準のoffset_headerに負ける事があるので、
		// このファイルで margin-top を 0 にして top に高さを指定しするという手法だと、
		// offset_header でつけられる margin-top の余白と、
		// このファイルでつける top の高さで余白が余分についてしまう事がsafariで時折発生するため、
		// margin-top でのみの指定としている。
		
		// 2020.4.19
		// だがしかし結局Lightning標準の処理に負けるため、bodyに識別用のクラスをつけて、Lightning標準の方は効かないように変更

		// スライドの位置を fix にして、表示開始位置を指定
		targetElement.css({ "margin-top":headerHeight + adminBarHeight + "px","position":"fixed","top":0 });

		// メインエリア上部にヘッダーとスライド分の余白を追加
		// 動作しない時がある場合は コメントアウトしてログを確認。本来は下記の行が2つ出力されるはず。
		// ただし、読み込みタイミングによっては１回だけしか実行されない時もある。
		// その為にこのファイルを読み込んだ時と、画像を読み込んだ時で２回実行した上でリサイズした時にも実行する設定としている
		// console.log("margin-top:" + headerHeight);
		targetElement.next().css({"margin-top":headerHeight + slideHeight + "px"});

		// 固定させる要素がない場合
		} else {
			$('.siteContent').css({"margin-top":headerHeight + "px"});
		}
	}

	// オフセット処理を実行（画像が既に読み込み完了している時のため）
	offset_top_slide();

	// 画像が表示された後にオフセット処理を実行
	// ※ bild処理は画像読み込みが、offset_top_slide() を読み込むより先に完了してしまうとうまく実行されない事がある
	$('.slide-item-img').bind("load", function(){
		offset_top_slide();
	  });

	// 動画の場合 //////////////////////////
	/* この処理がないとJPNSTYLE & アップロード動画 & 動画の高さにあわせる にした時に高さが検出できず動画が隠れてしまう */
	if ( $('.siteHeader').next().hasClass('vkvu')){
		// アップロード動画の場合
		if ( $('#vkvu_wrap').children().hasClass('vkvu_video')){
			var video_id = document.getElementById('vkvu_video');
			//動画の読み込みが完了したら
			video_id.addEventListener("canplay", function() {
				offset_top_slide();
			});
		}
	}

	// 管理バーが表示される時に、管理バーの高さが取得できずにその分スライド画像の位置が上にズレてしまうので、
	// 管理バーが表示されている時が document が読み込まれた後でオフセット処理を再実行
	if ( $('body').hasClass('admin-bar') ){
		$(document).ready(function(){
			offset_top_slide();
		});
	}

	// リサイズされた時の処理
	var timer = false;
	$(window).resize(function(){

		// timer が処理中（処理待ち）だったらtimerに登録されている処理をクリアする
		if ( timer !== false ){
			clearTimeout( timer );
		}
		// オフセット処理を実行
		timer = setTimeout(offset_top_slide, 300);
		// 最後にリサイズされた時から、指定された時間後に処理が実行されるので、
		// 複数同時に処理されなくなる
		// 200だとスライド上部の余白を正しく算出できず上部に余白が出来るので300以上にしておく
	});

	/*
	 シークレットウィンドウなどで動画読み込み時などに高さを取得できず動画が表示されない事があるため
	 スクロールする度に動画だったら高さ制御を走らせるというクソ実装
	*/
	$(window).scroll(function (e) {
		
		if ( $('.siteHeader').next().hasClass('vkvu')){
			
			// timer が処理中（処理待ち）だったらtimerに登録されている処理をクリアする
			if ( timer !== false ){
				clearTimeout( timer );
			}
			// オフセット処理を実行
			timer = setTimeout(offset_top_slide, 300);
			// 最後に実行された時から、指定された時間後に処理が実行されるので、
			// 複数同時に処理されなくなる
			// 200だとスライド上部の余白を正しく算出できず上部に余白が出来るので300以上にしておく
		}
	});

})(jQuery,document,window);
