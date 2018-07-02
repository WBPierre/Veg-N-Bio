#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <arpa/inet.h>
#include "/usr/include/mysql/mysql.h"

#include "core.h"

char* getUser(char* id, char* id_restaurant)
{
    char* query = calloc(2048, sizeof(char));
    strcpy(query, "SELECT * FROM vnb_users U, vnb_contract C, vnb_restaurant R WHERE U.id = ");
    strcat(query, id);
    strcat(query, " AND C.id_employee = ");
    strcat(query, id);
    strcat(query, " AND R.id = ");
    strcat(query, id_restaurant);
    return query;
}

void retrieveData(struct Employee *data, char *id, char *id_restaurant){
    MYSQL mysql;
    mysql_init(&mysql);
    mysql_options(&mysql,MYSQL_READ_DEFAULT_GROUP,"MYSQL_READ_DEFAULT_GROUP");
    if(mysql_real_connect(&mysql,"86.252.108.89","makia","project","VegNBio",0,NULL,0)){
        mysql_query(&mysql, getUser(id, id_restaurant));
        MYSQL_RES *result = NULL;
        MYSQL_ROW row;
        result = mysql_use_result(&mysql);
        while ((row = mysql_fetch_row(result))){
                data->id = atoi(row[0]);
                strcpy(data->name, row[1]);
                strcpy(data->firstname,row[2]);
                data->gender = atoi(row[3]);
                strcpy(data->email, row[4]);
                strcpy(data->birthdate,row[6]);
                strcpy(data->phone,row[7]);
                strcpy(data->date_created, row[11]);
                strcpy(data->job, row[15]);
                strcpy(data->contract_type, row[17]);
                strcpy(data->contract_start, row[18]);
                strcpy(data->contract_end, row[19]);
                data->id_restaurant = atoi(row[20]);
                strcpy(data->name_restaurant, row[28]);
                data->hour_number = atoi(row[21]);
                data->vacation_day_total = atoi(row[23]);
                strcpy(data->contract_inserted, row[25]);
        }
        if(result != NULL){
           mysql_free_result(result);
        }

        mysql_close(&mysql);
    }else{
        printf("Une erreur s'est produite lors de la connexion a la BDD!");
    }
}
