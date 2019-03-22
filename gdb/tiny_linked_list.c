// Tiny_linked_list is a demonstration program for using the heap and creating
// linked lists in C.
//
// The program requests an array of bytes from malloc and creates a linked list
// inside the array where each list node points to the previous node in the
// array.
//
// Example:
//   
// [Node0 <-- Node1 <-- Node2 <-- Node3 <-- Node4]
//  
// Thus, the head of the linked list is the last element of the array.
//
// The program then traces the linked list from head to tail, printing out the
// nodes.
//
// Jaylen VanOrden, CSE 351 TA, Autumn 2012

#include <stdio.h>
#include <stdlib.h>

// Preprocessor directives
#define NUM_NODES 10

// Struct definitions
struct node {
    int data;
    struct node *next;
};

// Function declarations
void printList(struct node *current);
struct node * setUpList(struct node *topOfArray);

// Main function
int main(int argc, char *argv[]){

  // Calculate the number of bytes to request from malloc()
  int size_of_array_in_bytes = sizeof(struct node) * NUM_NODES;

  // Create an empty pointer
  struct node *topOfArray;

  // Set the pointer to the beginning of the big array
  // Note: malloc() returns a void *.  The cast from (void *) to
  //      (struct node *) means "treat this memory as the type struct node".
  topOfArray = (struct node *)malloc(size_of_array_in_bytes);

  // Always check to see if malloc returned NULL
  if(topOfArray == NULL){
    printf("Out of memory - couldn't create node array!\n");
    return 1;
  }

  // Now, fill in the array, creating a linked list from the back to the
  // front (each node points at the previous node in the array).
  // The node in the front points to NULL.

  // Note: Never assume that memory returned from malloc() is zeroed-out.
  //       In other words, never read from memory you haven't written to.
  //       Here, we're just writing, so it's ok.
  struct node *headOfList = setUpList(topOfArray);

  // Now, trace/print the list back to the beginning
  printList(headOfList);

  // Finally, we are done with our list, so we should free it and set any
  // pointers into the free'd block to NULL.
  printf("Freeing the list and cleaning up pointers...\n");

  // Free the memory block that starts at topOfArray
  free(topOfArray);

  // Set the pointers into the array to NULL so we don't accidentally use them
  topOfArray = NULL;
  headOfList = NULL;

  printf("All done!\n");
  return 0;
}

// Fills in the array with a linked list.
// Returns a pointer to the last node in the array, which is the head of the
// linked list.
struct node * setUpList(struct node *topOfArray){
  int i;
  struct node *currentNode = NULL;
  struct node *previousNode = NULL;

  for(i = 0; i < NUM_NODES; i++){
    // Calculate a pointer to the next item in the array
    currentNode = topOfArray + i;
    currentNode->data = i;
    currentNode->next = previousNode;
    
    // Update the 'previous_node' pointer
    previousNode = currentNode;
  }

  return currentNode;
}

// Follows and prints the list
void printList(struct node *current){
  printf("Tracing the list...\n");
  while(current != NULL){
    printf("%p - [%d,%p]\n",current, current->data, current->next);
    // Follow the 'next' pointer to where it points (the previous node in the array)
    current = current->next;
  }
}
