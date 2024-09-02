import { Directive, ElementRef, HostListener, Input } from '@angular/core';

@Directive({
  selector: '[appCapitalizeAfter]',
})
export class CapitalizeAfterDirective {
  constructor(private el: ElementRef) {}

  @Input('appCapitalizeAfter') separators: string[] = [];

  @HostListener('input', ['$event'])
  onInputChange(event: Event) {
    const inputElement = event.target as HTMLInputElement;
    const value = inputElement.value;

    if (value) {
      inputElement.value = this.capitalizeAfterSeparators(
        value,
        this.separators
      );
    }
  }

  capitalizeAfterSeparators(value: string, separators: string[]): string {
    let result = value;

    separators.forEach((separator) => {
      result = result
        .split(separator)
        .map((word) => {
          if (word.length > 0) {
            return word.charAt(0).toUpperCase() + word.slice(1);
          }
          return word;
        })
        .join(separator);
    });

    return result;
  }
}
