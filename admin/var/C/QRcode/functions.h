#include <gd.h>
#include <qrencode.h>
#include <stdio.h>
#include <stdlib.h>
#include <stddef.h>
#include <time.h>
#include <string.h>
#include <unistd.h>
#include <sys/stat.h>

gdImagePtr qrcode_png (QRcode * code,int fg_color[3],int bg_color[3],int size,int margin);
int stringToQR(const char *content,FILE *out);