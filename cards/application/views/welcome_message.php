<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!doctype html>
<html lang="en">
    <head>
        <title>Title</title>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="<?php echo site_url()?>assets/bootstrap-rtl.css">
 
     </head>
    <body>  
        
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card card-body mt-5">
                        <?php 
                            $sound = $this->db->get("chat")->result();
                            foreach($sound as $s) {?>
                                <p><?= $s->date; ?></p>
                                <audio controls="controls">
                                    <source src="<?= $s->sound; ?>">
                                </audio>
                        <?php } ?>
                    </div>
                    <div class="card card-body mt-5">
                        <form action="<?= site_url()."welcome/save_msg"?>" method="post" enctype="multipart/form-data"> 

                            <div class="form-group">
                                <label for="textarea">اكتب الرسالة</label>
                                <textarea class="form-control" name="msg" id="textarea" rows="2" placeholder="اكتب ما تريد ان تستفسر عنه"></textarea>
                                <input type="hidden" name="file" id="file">
                            </div>

                            <div class="form-group row">
                                <div class="col-9">
                                    <button type="button" name="" class="btn btn-success"> ارفاق ملف</button>
                                    <button type="button" name="" class="btn btn-info" id="record" > تسجيل صوتي</button> 
                                    <button type="button" name="" class="btn btn-info" id="stopRecord" disabled> إيقاف التسجيل</button> 
                                    
                                </div>
                                <div class="col-3">
                                    <button type="submit" name="submit" class="btn btn-info">إرسال </button>
                                </div>
                            </div>
						</form> 
                    </div>
                    <div class="card card-body mt-5">
                        <form action="<?= site_url()."welcome/save_msg"?>" method="post" enctype="multipart/form-data"> 

                           <div class="type_msg justify-content-between">
								<div class="toolbar">
									<button class="button--start btn-recorde" id="record">
										<svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-mic" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
											<path fill-rule="evenodd" d="M3.5 6.5A.5.5 0 0 1 4 7v1a4 4 0 0 0 8 0V7a.5.5 0 0 1 1 0v1a5 5 0 0 1-4.5 4.975V15h3a.5.5 0 0 1 0 1h-7a.5.5 0 0 1 0-1h3v-2.025A5 5 0 0 1 3 8V7a.5.5 0 0 1 .5-.5z"/>
											<path fill-rule="evenodd" d="M10 8V3a2 2 0 1 0-4 0v5a2 2 0 1 0 4 0zM8 0a3 3 0 0 0-3 3v5a3 3 0 0 0 6 0V3a3 3 0 0 0-3-3z"/>
										</svg>
									</button>
									<button class="button--stop btn-recorde d-none" id="stopRecord">
										<svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-stop-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
											<path d="M5 3.5h6A1.5 1.5 0 0 1 12.5 5v6a1.5 1.5 0 0 1-1.5 1.5H5A1.5 1.5 0 0 1 3.5 11V5A1.5 1.5 0 0 1 5 3.5z"/>
										</svg>
									</button>
									<button class="button--trash btn-recorde d-none" id="trashRecord">
										<svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-trash" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
											<path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
											<path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
										</svg>
									</button> 
									<small id="timer" data-timer="00:00" class="text-white d-none px-4"> 00:00 </small> 
									<audio id="recordedAudio"></audio>
								</div> 

								<input type="text" class="write_msg form-control text-area" placeholder="ارسل لعبدالله ياسين" > 
								<button class="msg_send_btn" type="button">ارسال</button>
							</div>
							
							<div class="type_msg"> 
								<div class="file-drop-area">
									<span class="fake-btn">أختر الملف</span>
									<span class="file-msg">او قم بحسبه الى هنا</span>
									<input class="file-input" type="file" multiple>
								</div> 
							</div> 
						</form> 
                    </div>
                </div>
            </div>
        </div>
        <script src="https://lab.subinsb.com/projects/jquery/core/jquery-2.1.1.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
     
        <script>
            navigator.mediaDevices.getUserMedia({audio:true})
            .then(stream => {handlerFunction(stream)})

            function handlerFunction(stream) {
                rec = new MediaRecorder(stream);
                rec.ondataavailable = e => {
                    audioChunks.push(e.data);
                    if (rec.state == "inactive"){
                        let blob = new Blob(audioChunks,{type:'audio/mp3'});
                        recordedAudio.src = URL.createObjectURL(blob);
                        recordedAudio.controls = true;
                        recordedAudio.autoplay = false;
                        
                       sendData(blob)
                    }
                }
            }

            function sendData(blob) { 
                var reader = new FileReader();
                reader.readAsDataURL(blob); 
                reader.onloadend = function() {
                    var base64data = reader.result;
                    $("#file").val(base64data);
                }
            }

            record.onclick = e => {
                console.log('I was clicked')
                record.disabled = true;
                record.style.backgroundColor = "blue"
                stopRecord.disabled=false;
                audioChunks = [];
                rec.start();
            }

            stopRecord.onclick = e => {
                console.log("I was clicked")
                record.disabled = false;
                stop.disabled=true;
                record.style.backgroundColor = "red"
                rec.stop();
            }
        </script>
     </body>
</html>
