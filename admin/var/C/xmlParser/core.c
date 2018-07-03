#include "core.h"

char *itoa(long i, char* s, int dummy_radix) {
    sprintf(s, "%ld", i);
    return s;
}

void core( char *id, char *id_restaurant){
    Employee *data = initData();
    retrieveData(data, id, id_restaurant);
    handleXML(data);
    destroy(data);
}

void handleXML( Employee *data ){
    FILE *dest;
    char *folder;
    char *lastWord;
    folder = malloc(sizeof(char)*255);
    lastWord = malloc(sizeof(char)*255);
    getFileName(folder, data);
    if(fileExists(folder) == 0){
        dest = fopen(folder, "a");
        if(dest == NULL){
            printf("Error");
        }
        char *header;
        header = malloc(sizeof(char)*255);
        strcpy(header, "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n");
        fprintf(dest, "%s",header);
        fprintf(dest, "<employees>\n");
        insertEmployee(dest, data);
        fprintf(dest,"</employees>");
        free(header);
    }else{
        dest = fopen(folder, "r+");
        if(dest == NULL){
            printf("Error");
        }
        while(fgets(lastWord, 255, dest) != NULL){
            if(strcmp(lastWord,"</employees>") == 0){
                fseek(dest,-12,SEEK_CUR);
                insertEmployee(dest, data);
                fprintf(dest,"</employees>");
                break;
            }
        }
    }
    fclose(dest);
    free(lastWord);
    free(folder);
}

void insertEmployee(FILE *dest, Employee *data){
    char gender[10];
    char contract_start[255];
    char contract_end[255];
    strcpy(contract_end, "<contractEnd format=\"YYYY-MM-DD\">");
    strncat(contract_end, data->contract_end,10);
    strncat(contract_end,"</contractEnd>\n",16);
    strncpy(contract_start,data->contract_start,10);
    fprintf(dest, "<employee id=\"%d\">\n",data->id);
    switch(data->gender){
        case 0:
            strcpy(gender, "Sir");
            break;
        case 1:
            strcpy(gender, "Miss");
            break;
        default:
            strcpy(gender, "Other");
            break;
    }
    fprintf(dest,"<gender>%s</gender>\n",gender);
    fprintf(dest, "<name>%s</name>\n",data->name);
    fprintf(dest,"<firstname>%s</firstname>\n",data->firstname);
    fprintf(dest,"<email>%s</email>\n",data->email);
    fprintf(dest,"<birthdate format=\"YYYY-MM-DD \">%s</birthdate>\n",data->birthdate);
    fprintf(dest,"<phone>%s</phone>\n",data->phone);
    fprintf(dest,"<job>%s</job>\n",data->job);
    fprintf(dest,"<contract>%s</contract>\n",data->contract_type);
    fprintf(dest,"<contractStart format=\"YYYY-MM-DD\">%s</contractStart>\n",contract_start);
    fputs(contract_end,dest);
    fprintf(dest,"<hourNumber>%d</hourNumber>\n",data->hour_number);
    fprintf(dest,"<vacationDayTotal>%d</vacationDayTotal>\n",data->vacation_day_total);
    fprintf(dest, "</employee>\n");

}

int fileExists(char *folder){
    FILE *source;
    if((source = fopen(folder, "r"))){
        fclose(source);
        return 1;
    }else{
        return 0;
    }
}

void getFileName(char *folder, Employee *data){
    char transfer[50];
    strcpy(folder, "/var/www/dev/admin/admin/var/C/xmlParser/data/Restaurant/");
    itoa(data->id_restaurant, transfer, 10);
    strncat(folder, "0",1);
    strncat(folder, transfer,1);
    strncat(folder, data->name_restaurant, 5);
    strncat(folder, data->contract_inserted+5,2);
    strncat(folder, data->contract_inserted+2,2);
    strncat(folder, ".xml",4);
    printf("%s",folder);
}

Employee* initData(){
    Employee* e = malloc(sizeof(Employee));
    e->name = malloc(sizeof(char) * 50);
    e->firstname = malloc(sizeof(char) * 50);
    e->email = malloc(sizeof(char) * 30);
    e->birthdate = malloc(sizeof(char) * 11);
    e->phone = malloc(sizeof(char) * 10);
    e->date_created = malloc(sizeof(char) * 50);
    e->job = malloc(sizeof(char) * 30);
    e->contract_type = malloc(sizeof(char) * 5);
    e->contract_start = malloc(sizeof(char) * 20);
    e->contract_end = malloc(sizeof(char) * 20);
    e->name_restaurant = malloc(sizeof(char)*20);
    e->contract_inserted = malloc(sizeof(char) * 50);
    return e;
}

void destroy(Employee *data){
    free(data->name);
    free(data->firstname);
    free(data->email);
    free(data->birthdate);
    free(data->phone);
    free(data->date_created);
    free(data->job);
    free(data->contract_type);
    free(data->contract_start);
    free(data->contract_end);
    free(data->name_restaurant);
    free(data->contract_inserted);
    free(data);
}
