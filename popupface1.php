

<!-- Modal Shows PopUp Fanpage -->
<div class="modal fade" id="popfanpage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
  <!-- modal-dialog modal-lg" -->

    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Fanpage</h4>
      </div>
      <div class="modal-body">
        <div class="row">
        <div class="col-xs-12">
        <?=$school_fanpage_text?>
        <br>
        </div>
                 <div class="col-xs-12">
                 <iframe src="https://www.facebook.com/plugins/page.php?href=<?=$school_fanpage?>&tabs=timeline&width=500&height=500&small_header=true&adapt_container_width=false&hide_cover=false&show_facepile=true&appId" width="100%" height="500" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allow="encrypted-media"></iframe>


                </div>
              

            </div>
      </div>
      <div class="modal-footer">

        <!-- <button type="button" class="btn btn-default" data-dismiss="modal">ปิดหน้าต่าง</button> -->
        <center>  <button type="button" data-dismiss="modal" class="btn btn-default"   style="background-color:<?=$theme_color?>;" ><font color="#ffffff">รับทราบ</font></button></center>
      </div>
    </div>

  </div>
</div>