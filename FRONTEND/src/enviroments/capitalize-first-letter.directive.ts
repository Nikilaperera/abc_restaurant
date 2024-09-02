import { Directive, ElementRef, HostListener } from '@angular/core';

@Directive({
  selector: '[appCapitalizeFirstLetter]',
})
export class CapitalizeFirstLetterDirective {
  constructor(private el: ElementRef) {}

  @HostListener('input') onInput() {
    const inputValue = this.el.nativeElement.value;
    if (inputValue) {
      this.el.nativeElement.value =
        inputValue.charAt(0).toUpperCase() + inputValue.slice(1);
    }
  }
}
