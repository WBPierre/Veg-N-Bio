#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <arpa/inet.h>
#include "/usr/include/mysql/mysql.h"

#include "struct.h"
#include "sql.h"

char *itoa(long i, char* s, int dummy_radix);

void core( char *id, char *id_restaurant );

Employee* initData();

void destroy(Employee *data);

void handleXML(Employee *data);

void getFileName(char *folder, Employee *data);

int fileExists(char *folder);

void insertEmployee(FILE *dest, Employee *data);
