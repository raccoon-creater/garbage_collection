function resizeByWidth( img_id ) {
	var targetImg = document.getElementById(img_id);
	var orgWidth  = targetImg.width;
	var orgHeight = targetImg.height;
	targetImg.width = 300;
	targetImg.height = orgHeight * (targetImg.width / orgWidth);
}