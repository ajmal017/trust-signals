<?php header("Access-Control-Allow-Origin: *"); ?>
<meta http-equiv="Cache-Control" content="no-cache">

<div class="open-wrapper">
	<div class="open-header">
		<div class="ripple open-logout">
			<span class="fa fa-sign-out"></span>
		</div>
		<img class="open-avatar" src=""></img>
		<div class="open-info">
			<p class="open-title">{word_1}</p>
			<p class="open-time"><span class="fa fa-clock-o"></span> <span class="open-time-var"></span></p>
		</div>
	</div>
	<div data-id='0' class="open-get-news">
      	<span class="ripple fa fa-close"></span>
    	<p></p>
    </div>
	<div class="open-first-title open-title-signals">{word_2}</div>
	<div class="open-content">
		<div class="open-load-inside">
			<div class="open-load-row">
				<div class="open-load-cell">
					<img src="img/loadblue.svg" />
				</div>
			</div>
		</div>
	</div>
	<div class="open-settings">
		<div data-ripple="#fcfcfc" class="ripple open-title-signals open-link"><span class="fa fa-cog"></span> {word_4}</div>
		<div class="open-settings-box">
			<div class="open-set-title"><span class="fa fa-signal"></span> {word_5}</div>
			<div class="open-set-percent">0%</div>
			<div class="open-progress-box">
				<div data-ripple="#ddd" class="ripple open-dec">-</div>
				<div data-ripple="#ddd" class="ripple open-inc">+</div>
				<div class="open-wrap-progress">
					<div class="open-progress"></div>
				</div>
			</div>
			<div class="open-set-title open-two-title"><span class="fa fa-volume-up"></span> {word_6}</div>
			<p class="ripple open-volume"><span class='fa fa-bell-slash'></span> {word_7}</p>
			<div class="open-set-title"><span class="fa fa-language"></span> {word_74}</div>
			<p class="open-language"><a href="#" class="ripple to-translate" data-lang="ru">Русский</a> | <a class="ripple to-translate" href="#" data-lang="en">English</a></p>
			<div class="open-set-title"><span class="fa fa-code-fork"></span> {word_8}</div>
			<div class="open-pairs">
				<span class="fa fa-download"></span> {word_9}
			</div>
		</div>
	</div>
	<div class="open-days days-3">
		<div class="open-days-header">
			<div class="open-days-close days-3"><span class="fa fa-close"></span></div>
			<div class="open-days-title"><i class="fa fa-search"></i> {word_10}</div>
		</div>
		<div class="open-days-content days-3" style="height: auto;">
			<div class="open-select-bid open-select">
				<div data-value="0" class="ripple open-select-active">{word_11}</div>
				<ul class="ripple">
					<li data-value="eurusd">EUR/USD</li>
					<li data-value="gbpusd">GBP/USD</li>
					<li data-value="gbpjpy">GBP/JPY</li>
					<li data-value="xauusd">Gold</li>
					<li data-value="euraud">EUR/AUD</li>
					<li data-value="usdjpy">USD/JPY</li>
					<li data-value="usdcad">USD/CAD</li>
					<li data-value="usdchf">USD/CHF</li>
					<li data-value="nzdusd">NZD/USD</li>
					<li data-value="eurchf">EUR/CHF</li>
					<li data-value="eurgbp">EUR/GBP</li>
					<li data-value="gbpchf">GBP/CHF</li>
					<li data-value="audusd">AUD/USD</li>
				</ul>
			</div>
			<div class="open-select-pos open-select">
				<div data-value="0" class="open-select-active">{word_12}</div>
				<ul>
					<li data-value="up">{word_13}</li>
					<li data-value="down">{word_14}</li>
				</ul>
			</div>
			<div class="open-form">
				<input class="open-search-bid-price" type="text" value="{word_15}" />
			</div>
			<div class="open-bid-now-price">{word_16} <span class="open-search-pair-name">EUR/USD</span>: <span class="open-search-pair-price"><i class="fa fa-refresh"></i> {word_3}...</span></div>
    		<div class="open-search-add">
    			<div class="ripple open-search-add-btn">{word_17}</div>
    			<div data-ripple="#ccc" class="ripple open-search-sound"><i class="fa fa-circle"></i> {word_18}</div>
   			</div>
			<div class="open-search-view">
				<div class="open-search-header"><i class="fa fa-eye"></i> {word_19}</div>
				<div class="open-search-list-box">
					<div style="padding: 7px;"><i class="fa fa-plus-circle"></i> {word_20}</div>
				</div>
			</div>
    	</div>
	</div>
	<div class="open-days days-2">
		<div class="open-days-header">
			<div class="open-days-close days-2"><span class="fa fa-close"></span></div>
			<div class="open-days-title"><span class="fa fa-newspaper-o"></span> {word_21}</div>
		</div>
		<div class="open-days-content days-2" style="height: auto;">
			<div class="open-days-pair">
				<span class="fa fa-download"></span> {word_3}
			</div>
    	</div>
	</div>
	<div class="open-days days-1">
		<div class="open-days-header">
			<div class="open-days-close days-1"><span class="fa fa-close"></span></div>
			<div class="open-days-title"><span class="fa fa-calendar"></span> <?=date("Y-m-d")?></div>
		</div>
		<div class="open-days-content days-1">
			<div class="open-days-pair">
				<span class="fa fa-download"></span> {word_3}
			</div>
		</div>
	</div>
	<div class="open-days days-4">
		<div class="open-days-header">
			<div class="open-days-close days-4"><span class="fa fa-close"></span></div>
			<div class="open-days-title"><span class="fa fa-support"></span> {word_22}</div>
		</div>
		<div class="open-days-content days-4">
			<div class="open-days-pair">
				<div class="form-group">
					<p>{word_23}</p>
					<input class="ripple open-support-type"/>
				</div>
				<div class="form-group">
					<p>{word_24}</p>
					<textarea class="ripple open-support-question"></textarea>
				</div>
				<div class="form-group">
					<button data-ripple="#ddd" class="ripple open-support-send">{word_25}</button>
				</div>
			</div>
		</div>
	</div>
	<div class="open-menu">
		<div class="open-menu-hide"><span class="fa fa-chevron-left"></span></div>
		<div>
			<img class="open-menu-avatar" src=""></img>
		</div>
		<div class="open-status"><span class="fa fa-check-circle"></span> Online</div>
		<ul>
			<li class="ripple"><span class="open-menu-days"><i class="fa fa-signal"></i> {word_26}</span></li>
			<li class="ripple"><span class="open-menu-news"><i class="fa fa-newspaper-o"></i> {word_27}</span></li>
			<li class="ripple"><span class="open-menu-search"><i class="fa fa-search"></i> {word_28}</span></li>
			<li class="ripple"><span class="open-menu-support"><i class="fa fa-support"></i> {word_22}</span></li>
			<li class="ripple"><span class="open-menu-shop"><i class="fa fa-shopping-cart"></i> {word_29}</span></li>
			<li class="ripple"><span class="open-menu-logout"><i class="fa fa-sign-out"></i> {word_30}</span></li>
		</ul>
	</div>
	<div class="open-window">
		<div class="open-window-header"><span class="ripple-off open-window-close fa fa-close"></span> <span class="open-window-title"><span class="fa fa-download"></span> {word_3}</span></div>
		<div class="open-window-content" id="open-window-content">
			<span class="fa fa-download"></span> {word_3}
		</div>
	</div>
	<div class="open-window-dark">
		<div class="open-window-header-dark"><span class="open-window-close-dark fa fa-close"></span> <span class="open-window-title-dark"><span class="fa fa-download"></span> {word_3}</span></div>
		<div class="open-window-content-dark" id="open-window-content-dark">
			<span class="fa fa-download"></span> {word_3}
		</div>
	</div>
</div>