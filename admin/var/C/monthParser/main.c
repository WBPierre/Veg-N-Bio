#include <stdio.h>
#include <stdlib.h>
#include <sys/stat.h>
#include "/usr/include/mysql/mysql.h"

#include "core.h"


int main(int argc, char **argv)
{
    int response,i,j;
    int lineCounter;
    char year[50];
    char month[50];
    char folder[50];
    char id[2];
    char name[50];
    char getMonth[50];
    char destination[50];
    char source[50];
    char index[255];
    char *line;
    FILE *dest;
    FILE *reader;
    strcpy(getMonth,"");
    strcpy(id, "");
    struct dirent *lecture;
    DIR *rep;
    Restaurant *data[8];
    for(i=0;i<8;i++){
        data[i] = initData();
    }
    getYear(month,year);
    strcpy(folder, "/var/www/dev/admin/admin/var/C/data/Annual/");
    strcat(folder,year);
    strcpy(destination,folder);
    strncat(destination,"/",1);
    strncat(destination, month,2);
    strncat(destination, ".xml", 4);
    dest = fopen(destination, "w");
    fputs("<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n",dest);
    if((response = folderExists(folder))== 0){
        mkdir(folder,0755);
    }
    rep = opendir("/var/www/dev/admin/admin/var/C/data/Restaurant/" );
    while ((lecture = readdir(rep))) {
        if(strcmp(lecture->d_name,".") != 0){
            if(strcmp(lecture->d_name,"..") != 0){
                strcpy(source,"/var/www/dev/admin/admin/var/C/data/Restaurant/");
                strcat(source, lecture->d_name);
                reader = fopen(source, "r+");
                printf("%s\n",lecture->d_name);
                strncat(id, lecture->d_name,2);
                if(strncmp(id,"0",1) == 0){
                    strcpy(id, (char *)id+1);
                }
                strncat(getMonth,lecture->d_name+7,2);
                if(strcmp(getMonth,month) == 0){
                    retrieveData(data);
                    for(i=0;i<8;i++){
                        if(strcmp(data[i]->id,id) == 0){
                            break;
                        }
                    }
                    strcpy(index, "<restaurant name=\"");
                    strcat(index,data[i]->name);
                    strcat(index, "\" id=\"");
                    strcat(index, data[i]->id);
                    strcat(index, "\">");
                    fputs("<restaurants name=\"VegNBio\">\n",dest);
                    fputs(index, dest);
                    lineCounter = 0;
                    line = calloc(255,sizeof(char));
                    while(fgets(line,255, reader)){
                        if(lineCounter == 0){
                            lineCounter++;
                            continue;
                        }
                        fputs(line,dest);
                        lineCounter++;
                    }
                    fputs("\n</restaurant>",dest);
                }
            }

        }

    }
    fputs("\n</restaurants>",dest);
    fclose(dest);
    fclose(reader);
    for(i=0;i<8;i++){
        destroy(data[i]);
    }
    //free(data);
    closedir(rep);
    return 0;
}
