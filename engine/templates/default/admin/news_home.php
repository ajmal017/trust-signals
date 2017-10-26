<style>
    .hd {
        position: absolute;
        margin-top: -20px;
        margin-left: -15px;
        background-color: rgba(76, 14, 14, 0.46);
        width: 100%;
        height: 100%;
        opacity: 0;
    }

    .hd:hover {
        opacity: 1;
    }
</style>
<div class="add-news-box">
    <a class="btn btn-primary" href="%URI%/news_add/">Добавить новость</a>
</div>
%news%
<div class="modal fade bs-example-modal-lg" id="img-modal" tabindex="-1" role="dialog" aria-labelledby="img-signal-label">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content m-c-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel11"><span id="article-modal">...</span></h4>
            </div>
            <div class="modal-body" id="myModalLabel11">
                <center>
                    <img id="img-modal-full" style="max-width: 850px;" class="text-center" src="" alt=""/>
                </center>
            </div>
        </div>
    </div>
</div>