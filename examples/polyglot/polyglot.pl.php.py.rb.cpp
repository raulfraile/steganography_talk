#/*<?php eval('echo "PHP Code\n";'); __halt_compiler();?> */

#include <stdio.h> /*

print ((("b" + "0" == 0) and eval('"Perl Code\n"')) or (0 and "Ruby Code\n" or "Python Code"));

__DATA__ = 1
"""""
__END__

===== . ===== */

#ifdef __cplusplus
    char msg[9] = {'C','+','+',' ','C','o','d','e', '\n'};
#else
    char msg[7] = {'C',' ','C','o','d','e', '\n'};
#endif

int main() { int i; for(i = 0; i < 9; ++i) putchar(msg[i]); return 0;} /*

outputs:

  $ perl polyglot.pl.php.py.rb.cpp
  Perl Code
  $ php polyglot.pl.php.py.rb.cpp
  #PHP Code
  $ python polyglot.pl.php.py.rb.cpp
  Python Code
  $ ruby polyglot.pl.php.py.rb.cpp
  Ruby Code
  $ g++ -x c++ polyglot.pl.php.py.rb.cpp -o poly; ./poly
  C++ Code
  $ g++ -x c polyglot.pl.php.py.rb.cpp -o poly; ./poly
  C Code

"""
#*/