import { Directive, HostListener, ElementRef } from '@angular/core';

@Directive({
  selector: '[appCapitalizeAll]',
})
export class CapitalizeAllDirective {
  constructor(private el: ElementRef) {}

  @HostListener('input', ['$event']) onInput(event: Event): void {
    const input = this.el.nativeElement as HTMLInputElement;
    input.value = input.value.toUpperCase();
  }
}
