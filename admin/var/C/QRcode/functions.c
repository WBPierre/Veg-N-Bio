#include "functions.h"

#define TIME_LEN 30

gdImagePtr qrcode_png(QRcode *code, int fg_color[3], int bg_color[3], int size, int margin)
{
    int code_size = size / code->width;
    code_size = (code_size == 0)  ? 1 : code_size;
    int img_width = code->width * code_size + 2 * margin;
    gdImagePtr img = gdImageCreate (img_width,img_width);
    int img_fgcolor =  gdImageColorAllocate(img,fg_color[0],fg_color[1],fg_color[2]);
    int img_bgcolor = gdImageColorAllocate(img,bg_color[0],bg_color[1],bg_color[2]);
    gdImageFill(img,0,0,img_bgcolor);
    u_char *p = code->data;
    int x,y ,posx,posy;
    for (y = 0 ; y < code->width ; y++)
    {
        for (x = 0 ; x < code->width ; x++)
        {
            if (*p & 1)
            {
                posx = x * code_size + margin;
                posy = y * code_size + margin;
                gdImageFilledRectangle(img,posx,posy,posx + code_size,posy + code_size,img_fgcolor);
            }
            p++;
        }
    }
    return img;
}

int stringToQR(const char *content,FILE *out){
	int version = 3;
	QRecLevel level = 2;
	QRencodeMode hint = QR_MODE_8;
	int casesensitive =1;
	QRcode *pQR;
	gdImagePtr qr;
	int int_bg_color[3] = {255,255,255} ;
	int int_fg_color [3] = {0,0,0};
	int size = 150;
	int margin = 2;
	if(content == NULL || out == NULL)
		return 1;
	if((pQR = QRcode_encodeString (content,version,level,hint,casesensitive)) == NULL)
		return 2;
	qr = qrcode_png(pQR,int_fg_color,int_bg_color,size,margin);
	gdImagePng(qr,out);
	gdImageDestroy(qr);
	QRcode_free(pQR);
	fclose(out);
	return 0;
}
