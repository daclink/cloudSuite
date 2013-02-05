#include <stdio.h>
#include <stdlib.h>

int main () {
    int i;
    i = 0;
    i = system("python cmdForMe.py");
    printf("the value returned is \n%d\n",i);
    return 0;

}
