#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <malloc.h>
#include <arpa/inet.h>
#include "/usr/include/mysql/mysql.h"

#include "struct.h"
#include "core.h"
#include "sql.h"


int main(int argc, char **argv)
{
    core(argv[1], argv[2]);
    return 0;
}
