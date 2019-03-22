/* CSE 351 emacs intro!
 *
 * Hello CSE 351ers! 
 *   Welcome to emacs!
 *
 * The purpose of this tutorial is serve as a starting point for using the vi text editor. 
 * 
 *     A bit of Notation to Start:
 *          => C-x - hold down the control key and press x
 *          => M-x - hold down the meta key (alt by default) and press x
 *
 *     For now, hit     C-n     to move down and continue with the rest of this tutorial.
 *
 *     (WARNING NOTE: MAKE SURE YOU ARE NOT IN CAPS-LOCK MODE. 
 *          AS YOU'LL SEE, COMMANDS ARE CASE SENSITIVE)
 *
 * For those of you who aren't familiar emacs, emacs was made back in 1981 as part of the GNU project 
 * by Richard Stallman who has since passed on project development to others.
 *
 * But even though emacs has been around for a while, it's still many programmer's
 * editor of choice because of its power and configurablity. You may have heard that people can live in emacs,
 * which is sometimes closer to fact than fiction.
 *
 * Good luck, have fun,
 *   Your CSE 351 course staff
 *
 *
 */


/* Basics of emacs
 *
 * There's almost no end to the rabbit hole of exploring emacs, but in this tutorial we'll focus on providing
 * you all with a minimal starting point for editing in vanilla emacs.
 *
 * At the end of this tutorial, we'll touch a little upon what makes emacs more than just your average text editor,
 * and why so many people still choose emacs.
 *
 *      0. Exiting and Saving:
 *          In case you accidentally opened this file or just want to leave,
 *          here are some commands for helping you out.
 *              => C-x C-c - exit emacs
 *              => C-x C-s - save file
 *              => C-x C-f - prompts you for /your/file/path to open
 *              => M-x recover-session - recovers last session if emacs exited improperly
 *
 *              => C-g - aborts current command (very, very usefull...)
 *
 *      1. Moving the cursor:
 *                          In normal mode, arrow keys are mapped to keys
 *              ^           around home row (C-b, C-n, C-p, C-f) for left, down, up, right). 
 *             C-p          Although most systems now have support
 *       < C-b     C-f >    for arrow keys in emacs, you may find it useful to learn
 *             C-n          these remappings to so you don't have to move around
 *              v           the keyboard as much
 *
 *
 *      2. More Navigation:
 *          In addition to moving around by units of characters, we other options in emacs as well.
 *
 *          Here are some more ways you can navigate around text:
 *              => M-f - move to the begining of the next word
 *              => M-b - move to the begining of the previous word
 *                  (Note: this pattern of C-f refering to the smallest unit (a character)
 *                         and M-f refering to a larger unit (a word) is common throughout 
 *                         the vanilla emacs key-binding)
 *
 *
 *              => C-a - move to the end of the current line
 *              => C-e - move to the begining of the current line
 *
 *              => M-} - move to end of next paragraph
 *              => M-{ - move to begining of paragraph 
 *
 *              => C-v - move one screen forward
 *              => M-v - move one screen backwards
 *              => C-l - redraw screen and moves cursor selected line to the middle of the screen
 *
 *      3. Editing Text:
 *          Lets start introducing some commands in emacs:
 *              => C-x u  or  C-/ - undo previous edit
 *
 *              => <DEL> - delete previous character (backwards) (<DEL> = delete/backspace)
 *              => C-d - delete selected character (forwards)
 *
 *              => M-<DEL> - kill previous word (backwards)
 *              => M-d - kill selected word (forwards)
 *
 *              => C-k - kill the rest of the current line
 *
 *              => C-y - Paste back last copied or killed text
 *
 *          To copy or kill a specific region of text, 
 *              1. Press C-<SPC> to start the highlighted kill region (<SPC> = Space)
 *              2. Navigate to end of the desired region
 *              3. Press M-w to copy or C-w to kill region
 *
 *          Transposition Commands: (swaps the position of the current text with the previous text)
 *              => C-t - transpose characters
 *              => M-t - transpose word
 *              => C-x C-t - transpose line
 *
 *          Try using what you know to re-order and fix this unfortunate student's shopping list.
 *              (hint. Try using either the kill-paste commands or reordering with just transposes)
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
 *              => M-g M-g 38 - jump to the 38th line in the file
 *              => C-x C-<SPC> - jump back to the cusor's previous location
 *
 *          To continue to the next part of this tutorial, try jumping to line 140
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
 *      Now to complete this part of the tutoral, try using what you already know to try fixing this student's doctor's note.
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
 */



/* 
 * emacs text editor intro, Part 2
 */


/* 2.1
 *
 * To start working with this simple c prgram below, lets first clean up some of these repeated imports
 *
 * Try using the C-<SPC> command to start a kill region and C-w to kill it
 */

#include <stdio.h>
#include <stdio.h>
#include <stdio.h>
#include <stdio.h>
#include <stdlib.h>

/* 2.2
 *
 * Here, we're declaring a funciton that we'll use later in the program.
 * To find where it's defined, use the    C-s xxx    command to find occurances of 'xxx' in the file
 * Try it here by typing    C-s print_operation    , 
 * then hit    C-s    again to jump to the next occurance in the file.
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
         * To use the emacs find and replace function
         * Type     M-% aaa <RET> bbb <RET>    cycle all occurances of 'aaa' and prompt you for a y/n response for
         * each one on whether or not to replace it.
         * (<RET> = Return)
         *
         * y - replace occurance
         * n - skip occurance
         * <RET> - exit find/replace
         */
        printf("Usage: ./calculator opernand1 opernand2 operator\n");
        return 1;
    }
    
    /* 2.4
     *
     * Take a look at the code from below
     * It looks like we've called a function on variables that we havent declared yet
     * To fix this, lets use the highlighting and killing functions we saw earlier in this tuorial
     * 
     */
    char operator = argv[3][0];
    print_operation(a, b, operator)

    // try using C-<SPC> to highlight and move two lines above the function call above
    // by using the C-w and C-y kill and paste shortcuts referenced above
    int a = atoi(argv[1]);
    int b = atoi(argv[2]);
 

    return 0;
}

/* 2.2 cont.
 *
 * You found me!
 * Now either hit   C-r   jump to the previous occuance of the search, 
 * or hit   C-s   again to loop back from the begining of the file
 */
void print_operation(int a, int b, char operator)
{

    int result = 0;

    switch(variable) 
    {
        /* 2.5
         *
         * It looks like we have another set of casing typos here inside of our program
         * We can't really use our regular search and replace command we used above for this since the typo appears on multiple lines
         *
         * To fix thix, we can either use find and replace by using   M-% aaa <RET> bbb <RET>     to find and replace as you did above,
         * or we can use some more emacs functions to help us.
         *
         * M-u - Change word to Upper Case
         * M-l - Change word to Lower Case
         *
         * Here, since we want everything lower case anyways, we can just repeat M-l to advance through the text and replace casing
         */
        CASE '+':
            result = a + b;
            BREAK;
        CASE '-':
            result = a - b;
            BREAK;
        CASE '/':
            result = a / b;
            BREAK;
        CASE 'x':
            result = a * b;
            BREAK;
        CASE '%':
            result = a % b;
            BREAK;
        default:
            printf("Invalid operator\n");
            return;
    }
    printf("%d %c %d = %d\n", a, operator, b, result);
}

/* END
 *
 * This concludes this short introduction to emacs. 
 * If everything was done correctly, then you should be able to complile and run this program as a simple calculator
 *
 * There alot more to emacs than just these commands.
 * The bulk of emacs power is in its extensibility as opposed to its out-of-the-box editing capabilities.
 *
 *
 * Back in the days of the great editor war, vi/vim users would often call emacs "a great operating system, lacking only a decent editor"
 * As an emacs user that vi/vim keybindings throughout emacs (lookup EVIL mode if you're intereted).
 *
 * If you still have questions or want to learn more about this powerful editor, I encourage you to ask around or 
 * check out more indepth tutorials such as the one emacs provides (just hit   C-h t    in emacs to open it)
 *
 * Also, if you're still new to emacs and are just trying to get get around, you may find it helpful to have a basic cheat sheet of commands
 * open when you're editing files.
 * Here's one that you may find useful:
 * https://www.gnu.org/software/emacs/refcards/pdf/refcard.pdf
 */ 

