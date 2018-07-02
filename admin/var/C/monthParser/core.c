#include "/usr/include/mysql/mysql.h"

#include "core.h"


int folderExists(char *folder){
    DIR* dir = opendir(folder);
    if (dir){
        closedir(dir);
        return 1;
    }else if (ENOENT == errno){
        return 0;
    }else{
        return -1;
    }
}

void getYear(char *month,char *year){
    char yearNumber[50];
    time_t mytime = time(NULL);
    struct tm tm = *localtime(&mytime);
    strcpy(year,"year");
    sprintf(yearNumber,"%d",tm.tm_year+1900);
    strcat(year,yearNumber);
    sprintf(month,"%d",tm.tm_mon);

    if(strlen(month) == 1){
        char monthParsed[50];
        strcpy(monthParsed,"0");
        strcat(monthParsed,month);
        strcpy(month,monthParsed);
    }
}


void retrieveData(Restaurant **data){
    MYSQL mysql;
    mysql_init(&mysql);
    mysql_options(&mysql,MYSQL_READ_DEFAULT_GROUP,"MYSQL_READ_DEFAULT_GROUP");
    if(mysql_real_connect(&mysql,"localhost","makia","project","VegNBio",0,NULL,0)){
        char requested[255] = "SELECT * FROM vnb_restaurant";
        mysql_query(&mysql, requested);
        unsigned int maxID = 0;
        int i = 0;
        MYSQL_RES *result = NULL;
        MYSQL_ROW row;
        result = mysql_use_result(&mysql);
        while ((row = mysql_fetch_row(result))){
            strcpy(data[i]->id, row[0]);
            strcpy(data[i]->name, row[1]);
            i++;
        }
        if(result != NULL){
           mysql_free_result(result);
        }

        mysql_close(&mysql);
    }else{
        printf("Une erreur s'est produite lors de la connexion a la BDD!");
    }
}

Restaurant *initData(){
    Restaurant *r = malloc(sizeof(Restaurant));
    r->id = malloc(sizeof(char)*2);
    r->name = malloc(sizeof(char)*50);
    return r;
}

void destroy(Restaurant *data){
    free(data->id);
    free(data->name);
    free(data);
}
