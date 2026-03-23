export interface ButtonOptions {
  text: string;
  variant?: 'primary' | 'secondary';
  onClick?: (event: Event) => void;
}

export function createButton(options: ButtonOptions): HTMLButtonElement {
  const button = document.createElement('button');
  button.textContent = options.text;
  button.className = `btn btn-${options.variant || 'primary'}`;

  if (options.onClick) {
    button.addEventListener('click', options.onClick);
  }

  return button;
}
