/* CSE 351 vi/vim introduction!
 *
 * Hello CSE 351ers! 
 *   Welcome to vi/vim!
 *
 * The purpose of this tutorial is serve as a starting point for using the vi text editor. 
 * 
 *     For now, hit the     j     key to move down and continue with the rest of this tutorial.
 *     (if you are for some reason entering text by hitting j, hit esc (escape) and try again)
 *
 *     (WARNING NOTE: MAKE SURE YOU ARE NOT IN CAPS-LOCK MODE WHEN USING VIM. 
 *          AS YOU'LL SEE, COMMANDS ARE CASE SENSITIVE)
 *
 * For those of you who aren't familiar vi or vim (vi-imporoved), vi is a 
 * highly configureable text editor that has been around for ages, since it was first
 * written in 1976. 
 *
 * But even though vi/vim has been around for a while, it's still many programmer's
 * editor of choice because of its efficiency, portability, and configurablity.
 *
 * Good luck, have fun,
 *   Your CSE 351 course staff
 *
 *
 */


/* Basics of Vim
 *
 * The first thing to know about vim is that vim is a MODAL editor. 
 * This means that vim has different modes that change what keystrokes will do. 
 *
 * We'll go over the most important modes for editing text here below to get you started!
 *
 *
 * NORMAL MODE
 *      When you first open a file, vim puts you in NORMAL mode. 
 *      Normal mode allows you to navigate around a file, move blocks of text, and more.
 *      
 *      *** To return to normal mode, hit the escape (esc) key ***
 *
 *      0. Exiting and Saving:
 *          In case you accidentally opened this file or just want to leave,
 *          here are some commands for helping you out.
 *              => :q - quit a file (will fail if there are unsaved edits)
 *              => :q! - force quit a file without saving changes
 *              => :w - write (save) file
 *              => :wq - write and quit file
 *
 *      1. Moving the cursor:
 *                          In normal mode, arrow keys are mapped to keys
 *              ^           around home row (h, j, k, l for left, down, up, right). 
 *              k           Although most systems now have support
 *         < h     l >      for arrow keys in vim, you may find it useful to learn
 *              j           these remappings to so you don't have to move around
 *              v           the keyboard as much
 *
 *
 *      2. Text objects:
 *          In vim, there's the concept of a text object. Instead of just moving
 *          around 1 character at a time, we can navigate by units of words or 
 *          paragraph depending on our needs.
 *
 *          Here are some more ways you can navigate around text:
 *              => w - move to the begining of the next word
 *              => e - move to the end of the next word
 *              => b - move to the begining of the previous word
 *
 *              => } - move to the end of the paragraph (block of text)
 *              => { - move to the begining of the paragraph (block of text)
 *
 *      3. Cutting, Copying, and Pasting text:
 *          Lets start introducing some commands in vim:
 *              => x - delete character
 *              => dw - delete word (will not include text in front of the cursor)
 *              => dd - delete a line
 *
 *              => yy - copy (yank) a line of text
 *
 *              => p - paste last deleted or yanked line of text after/below cursor
 *              => P - paste last deleted or yanked line of text before/above cursor
 *
 *              => u - undo previous edit (not quite cutting and pasting but extreemly useful) 
 *
 *         Try using what you know to re-order and fix this unfortunate student's shopping list.
 *
 *              Jill'''s Shoppping List:
 *                  2. grade a eggs eggs
 *                  1.. milk
 *                  4. green green avOocados
 *                  3. peanut junk junk buttter
 *                  5. stuffff...
 *
 *
 *
 *      4. More Navigation:
 *          Finally, we can also jump to sepecific line in a file
 *              => 38G - jump to the 38th line in the file
 *              => Ctrl + o - jump back to the cusor's previous location
 *
 *          To continue to the next part of this tutorial, try jumping to line 140 to learn about
 *          the other major mode in vim 
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 * INSERT MODE
 *      Insert mode is probably what's going to feel most natural to most of you since we finally get to enter text.
 *          => i - enter insert mode
 *          => esc - exit insert mode (back to normal mode)
 *
 *      There are alot more specific ways of entering insert mode if you're feeling like a vim ninja.
 *          => a - insert text after (append) cursor's current position
 *
 *          => o - start a new line below the cursor and begin entering text
 *          => O - start a new line above the cursor and begin entering text 
 *
 *          => cc - delete line and enter insert mode
 *          => s - delete character and enter inert mode
 *
 *      Now start using insert mode and what you already know to try fixing this student's doctor's note.
 *
 *          Dear Mrs. Rothfuss,
 *             Please excuse my sun Jill from schoool tuday because becuse
 *             he is very siik and tiired and needs needs to go the doctrs offise.
 *          From,
 *          ,
 *          jillss mom.
 *             
 *
 *
 * That's the basic rundown of the vim text editor.
 *
 * If you want to learn more, try following along with editing this basic c program
 */


/* 
 * vi/vim text editor intro, Part 2
 */


/* 2.1
 *
 * In vim, we can specify repeated actions
 * For example, 7x will delete the next 7 characters
 * and 6j will move you down 6 lines.
 *
 * Try using this and the   dd    command to clean up the repeated imports below
 */

#include <stdio.h>
#include <stdio.h>
#include <stdio.h>
#include <stdio.h>
#include <stdlib.h>

/* 2.2
 *
 * Here, we're declaring a funciton that we'll use later in the program.
 * To find where it's defined, use the /xxx command to find occurances of 'xxx' in the file
 * Try it here by typing    /print_operation    in normal mode
 * then use the     n    key to jump to the next occurance in the file.
 */
void print_operation(int a, int b, char operator);

int main(int argc, char **argv)
{
    if (argc != 4)
    {
        /* 2.3
         *
         * Oh no! 
         * In our print statement we misspelled the operand as operNAND
         * Try and use vim's find a replace command to change all occurances of the type in the current line
         * type     :s/aaa/bbb/g    to replace all occurances of 'aaa' with 'bbb' in the current line
         */
        printf("Usage: ./calculator opernand1 opernand2 operator\n");
        return 1;
    }
    
    /* 2.4
     *
     * Take a look at the code from below
     * It looks like we've called a function on variables that we havent declared yet
     * To fix this, we can use another mode in vim called Visual Mode
     * 
     * To enter and exit visual mode, press the     v    key
     * In visual mode, we can move the cursor as we usually would to select blocks of text to cut, copy, and more
     */
    char operator = argv[3][0];
    print_operation(a, b, operator)

    // try using visual mode to move these two lines above the function call above by selecting them in visual mode
    // then pressing    d   to delete them and    p    to paste them above
    int a = atoi(argv[1]);
    int b = atoi(argv[2]);
 

    return 0;
}

/* 2.3
 *
 * You found me!
 * Now either hit   N   jump to the previous occuance of the search, 
 * or hit   n   again to loop back from the begining of the file
 */
void print_operation(int a, int b, char operator)
{
    int result = 0;
    /* 2.5
     * 
     * Take a look at the switch statement below
     * One thing you should notice is that the arguements for switch() should be the variables operand, and not (a, b)
     * To fix this, we can use the      c     command which we already talked about in a new way form new vim command
     *
     * Try moving the cursor somewhere inside the parentheses and typing    ci)     which stands for Change Inside Parentheses
     * to delete the current text inside, and enter insert mode to begin replacing it
     *
     * This pattern of combining command works for all sorts of commands in vim, and if you want to learn more I encourage you check this out
     */ 
    switch(a, b) 
    {
        /* 2.6
         *
         * It looks like we have another set of typos here inside of our program
         * We can't really use our regular search and replace command we used above for this since the typo appears on multiple lines
         *
         * To fix thix, we can use a global find and replace by typing      %s/aaa/bbb/g    to replace ALL occurances of 'aaa' with 'bbb' in the entire file
         */
        csae '+':
            result = a + b;
            break;
        csae '-':
            result = a - b;
            break;
        csae '/':
            result = a / b;
            break;
        csae 'x':
            result = a * b;
            break;
        csae '%':
            result = a % b;
            break;
        default:
            printf("Invalid operator\n");
            return;
    }
    printf("%d %c %d = %d\n", a, operator, b, result);
}

/* END
 *
 * This concludes this short introduction to vim. 
 * If everything was done correctly, then you should be able to complile and run this program a a simple calculator
 *
 * If you still have questions or want to learn more about this amazingly powerful text editor, I encourage you to ask around or 
 * check out more indepth tutorals such as openvim.com or vimtutor (just type vimtutor into your terminal and it should pop up).
 *
 * Also, if you're still new to vim and are just trying to get get around, you may find it helpful to have a basic cheat sheet of commands
 * open when you're editing files.
 * Here's one that you may find useful:
 * https://vim.rtorr.com/
 */ 
