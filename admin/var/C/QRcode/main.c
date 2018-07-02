#include "functions.h"

#define MAXLEN 200

int main(int argc,char *argv[]){
	FILE *pf;
	char fileOut[255];
	int choice;
	strcpy(fileOut, "/var/www/dev/admin/admin/var/C/employees/");
    strcat(fileOut,argv[1]);
    strncat(fileOut,".png",4);
    if((pf = fopen(fileOut,"wb")) == NULL){
        printf("The file could not be open\n");
        return EXIT_FAILURE;
    }
    if(stringToQR(argv[2],pf) != 0){
        printf("Error in the creation of the QRcode\n");
        return EXIT_FAILURE;
    }
	return EXIT_SUCCESS;
}
