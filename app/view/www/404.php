<!DOCTYPE html>
<!--


                                         
                                   .. .vr       
                                 qBMBBBMBMY     
                                8BBBBBOBMBMv    
                              iMBMM5vOY:BMBBv        
              .r,             OBM;   .: rBBBBBY     
              vUL             7BB   .;7. LBMMBBM.   
             .@Wwz.           :uvir .i:.iLMOMOBM..  
              vv::r;             iY. ...rv,@arqiao. 
               Li. i:             v:.::::7vOBBMBL.. 
               ,i7: vSUi,         :M7.:.,:u08OP. .  
                 .N2k5u1ju7,..     BMGiiL7   ,i,i.  
                  :rLjFYjvjLY7r::.  ;v  vr... rE8q;.:,, 
                 751jSLXPFu5uU@guohezou.,1vjY2E8@Yizero.    
                 BB:FMu rkM8Eq0PFjF15FZ0Xu15F25uuLuu25Gi.   
               ivSvvXL    :v58ZOGZXF2UUkFSFkU1u125uUJUUZ,   
             :@kevensun.      ,iY20GOXSUXkSuS2F5XXkUX5SEv.  
         .:i0BMBMBBOOBMUi;,        ,;8PkFP5NkPXkFqPEqqkZu.  
       .rqMqBBMOMMBMBBBM .           @kexianli.S11kFSU5q5   
     .7BBOi1L1MM8BBBOMBB..,          8kqS52XkkU1Uqkk1kUEJ   
     .;MBZ;iiMBMBMMOBBBu ,           1OkS1F1X5kPP112F51kU   
       .rPY  OMBMBBBMBB2 ,.          rME5SSSFk1XPqFNkSUPZ,.
              ;;JuBML::r:.:.,,        SZPX0SXSP5kXGNP15UBr.
                  L,    :@sanshao.      :MNZqNXqSqXk2E0PSXPE .
              viLBX.,,v8Bj. i:r7:,     2Zkqq0XXSNN0NOXXSXOU 
            :r2. rMBGBMGi .7Y, 1i::i   vO0PMNNSXXEqP@Secbone.
            .i1r. .jkY,    vE. iY....  20Fq0q5X5F1S2F22uuv1M; 


    又看源码,看你妹呀!


-->
<html>
<head>
    <meta charset="utf-8" />
    <title>404 - belin_wu.blog {}</title>
    <link rel="stylesheet" href="http://wujilin.com/assets/bootstrap/css/bootstrap.css" />
    <script type="text/javascript" src="http://wujilin.com/assets/jquery.js"></script>
    <script type="text/javascript" src="http://wujilin.com/assets/bootstrap/js/bootstrap.js"></script>
    <link rel="stylesheet" href="http://wujilin.com/assets/highlight/styles/github.css">
    <script src="http://wujilin.com/assets/highlight/highlight.js"></script>
    <script type='text/javascript' src='http://wujilin.com/assets/bootstrap-modal/js/bootstrap-modalmanager.js'></script>
    <script type='text/javascript' src='http://wujilin.com/assets/bootstrap-modal/js/bootstrap-modal.js'></script>
    <link rel='stylesheet' href='http://wujilin.com/assets/bootstrap-modal/css/bootstrap-modal.css' />
    <link rel="stylesheet" href="http://wujilin.com/css/app.css" />
    <link rel="shortcut icon" href="http://wujilin.com/img/favicon.ico" />
    <script type="text/javascript">
        $(function () {
            hljs.initHighlightingOnLoad();

            <?php if (isset($active)) { ?>
                $('.nav:first li[key=<?=$active?>]').addClass('active');
            <?php } ?>

            $('#wjl-goto-top').on('click', function(event) {
                event.preventDefault();
                $('html, body').animate({scrollTop: 0}, 'fast');
            });

            $('#wjl-goto-bottom').on('click', function(event) {
                event.preventDefault();
                $('html, body').animate({
                    scrollTop: $(document).height()
                }, 'fast');
            });

            $('#wjl-op-link-tip').tooltip({
                placement: 'right'
            });
        });
    </script>
</head>
<body>
    <div class="navbar navbar-fixed-top">
        <div class="navbar-inner">
            <div class="container">
                <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <div class="nav-collapse collapse">
                    <ul class="nav">
                        <li key='home'>
                            <a href="http://wujilin.com">首页</a>
                        </li>
                        <li key='about'>
                            <a href="http://wujilin.com/about">关于</a>
                        </li>                        
                        <li class="divider-vertical"></li>
                        <li key='archive'>
                            <a href="http://wujilin.com/archive">归档</a>
                        </li>
                        <li key='category'>
                            <a href="http://wujilin.com/category">分类</a>
                        </li>
                        <li key='series'>
                            <a href="http://wujilin.com/series">系列</a>
                        </li>                        
                        <li key='tag'>
                            <a href="http://wujilin.com/tag">标签</a>
                        </li>                   
                    </ul>                    
                    <ul class="nav pull-right">
                        <li>
                            <a href="http://wujilin.com">belin_wu.blog {}</a>
                        </li>                        
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <a href="https://github.com/belinwu">
        <img id="fork-me" src="http://wujilin.com/img/right-darkblue.png" alt="Fork me on GitHub" />
    </a>
    <div class="wjl-main">
		<div class="wjl-entries">
		    <div class="wjl-entries-header">
		        <div class="wjl-entries-title">
		            <a>404 | 对不起，页面未找到！</a>
		        </div>
		    </div>
		</div>

<?php include __DIR__ . '/footer.php'; ?>