#include <stdio.h>

int main(int argc, char *argv[]) {

    int i = 1;

    if(argc >1){
        printf("Called grapher with the options:\n");

        while(i < argc){
            printf("argv[%d] : %s\n",i,argv[i]); 
            i++;
        }
    } else {
        printf("you didn't supply any options!\n");
    }
    return 0;

}
