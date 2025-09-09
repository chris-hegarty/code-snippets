```scss

$industry: "Industry", serif;
$opensans: "Open Sans", serif;
$acumin-pro: "Acumin Pro", sans-serif;

//Adding these in here for now.

/*
Fluid font-size clamp set with calculator at https://chrisburnell.com/clamp-calculator/
The 1st font-size declaration is the fallback.
Final pixel value can be double checked in the inspector's "Computed" section.
*/

    h1 {
        //65px, 48px
        font-size: 4rem;
        font-size: clamp(3rem, 2.545rem + 1.939vw, 4rem);
    
        &.large {
            //80px, 48px
            font-size: 5rem;
            font-size: clamp(3rem, 1.571rem + 4.571vw, 5rem);
    
        }
    }
    
    h2 {
        //50px, 37px
        font-size: 3.125rem;
        font-size: clamp(2.25rem, 1.196rem + 2.571vw, 3.125rem);
    
        &.small {
            //40px, 33px
            font-size: 2.5rem;
            font-size: clamp(2.063rem, 1.75rem + 1vw, 2.5rem);
        }
    
    }
    
    h3 {
        //35px, 28px
        font-size: 2.18rem;
        font-size: clamp(1.75rem, 1.438rem + 1vw, 2.18rem);
    }
    
    h4, .card-title {
        //25px, 19px
        font-size: 1.56rem;
        font-size: clamp(1.188rem, 0.92rem + 0.857vw, 1.563rem);
    
        &.large {
            //30px, 23px
            font-size: 1.875rem;
            font-size: clamp(1.438rem, 1.125rem + 1vw, 1.875rem);
        }
    
    }
    
    p {
        //20px, 18px
        font-size: 1.25rem;
        font-size: clamp(1rem, 0.821rem + 0.571vw, 1.25rem);
        //18px, 16px
        &.small {
    
            font-size: 1.12rem;
            font-size: clamp(1rem, 0.911rem + 0.286vw, 1.125rem);
    
        }
    
        &.lead-in {
            //30px, 23px
            font-size: 1.875rem;
            font-size: clamp(1.438rem, 1.125rem + 1vw, 1.875rem);
        }
    
    }
    
    .tab-title {
        //30px, 23px
        font-size: 1.875rem;
        font-size: clamp(1.438rem, 1.125rem + 1vw, 1.875rem);
    }

/* tabs 22px mobile 29px desktop */

```