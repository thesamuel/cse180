#include <stdio.h>

/*
 * Loops through an array of integers, setting each to 0xbeef. Then
 * sets the 5th element of the array to 0x01.
 */
int main(int agrc, char **argv) {
  int array[10];
  int i;

  for (i = 0; i < 10; i++) {
    array[i] = 0xbeef;
    printf("Just added beef to %p\n", array + i);
  }

  printf("Writing the number 1...\n");
  *(array+4) = 0x01;

  printf("All done!\n");

  return 0;
}