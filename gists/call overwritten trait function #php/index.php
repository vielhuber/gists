trait A {
    function calc($v) {
        return $v+1;
    }
}

class MyClass {
    use A {
        calc as protected traitcalc;
    }

    function calc($v) {
        $v++;
        return $this->traitcalc($v);
    }
}