#include <stdio.h>

int main() 
{
    int j = 0; 
    for (int i = 0; i <9;i++)
    {
        for (; j <i; j++)
        {
            printf("#");
        }
        printf("\n");
        j = 0;
    }
}