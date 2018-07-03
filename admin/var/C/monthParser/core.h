#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <time.h>
#include <dirent.h>
#include <errno.h>
#include "/usr/include/mysql/mysql.h"

#include "struct.h"

int folderExists(char *folder);

void getYear(char *month, char *year);

void retrieveData(Restaurant **data);

void destroy(Restaurant *data);

Restaurant* initData();
