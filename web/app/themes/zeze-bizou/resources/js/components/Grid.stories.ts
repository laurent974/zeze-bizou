import type { StoryObj, Meta } from '@storybook/html';

const meta: Meta = {
  title: 'Layout/Grid',
  argTypes: {
    columns: {
      control: { type: 'range', min: 1, max: 12 },
    },
  },
};

export default meta;

type Story = StoryObj;

const createGrid = (columns: number): HTMLElement => {
  const container = document.createElement('div');
  container.className = 'container mt-4';

  const row = document.createElement('div');
  row.className = 'row';

  for (let i = 0; i < columns; i++) {
    const col = document.createElement('div');
    col.className = 'col';

    const innerDiv = document.createElement('div');
    innerDiv.style.background = '#007cba';
    innerDiv.style.color = 'white';
    innerDiv.style.padding = '20px';
    innerDiv.style.marginBottom = '10px';
    innerDiv.style.textAlign = 'center';
    innerDiv.textContent = `Col ${i + 1}`;

    col.appendChild(innerDiv);
    row.appendChild(col);
  }

  container.appendChild(row);
  return container;
};

export const TwoColumns: Story = {
  args: {
    columns: 2,
  },
  render: (args) => createGrid(args.columns),
};

export const ThreeColumns: Story = {
  args: {
    columns: 3,
  },
  render: (args) => createGrid(args.columns),
};

export const FourColumns: Story = {
  args: {
    columns: 4,
  },
  render: (args) => createGrid(args.columns),
};

export const Responsive: Story = {
  args: {
    columns: 12,
  },
  render: () => {
    const container = document.createElement('div');
    container.className = 'container mt-4';

    const row = document.createElement('div');
    row.className = 'row';

    // Large screens: 3 columns
    // Medium screens: 2 columns
    // Small screens: 1 column
    for (let i = 0; i < 6; i++) {
      const col = document.createElement('div');
      col.className = 'col-sm-12 col-md-6 col-lg-4';

      const innerDiv = document.createElement('div');
      innerDiv.style.background = '#6c757d';
      innerDiv.style.color = 'white';
      innerDiv.style.padding = '20px';
      innerDiv.style.marginBottom = '10px';
      innerDiv.style.textAlign = 'center';

      const title = document.createElement('div');
      title.textContent = `Responsive ${i + 1}`;
      innerDiv.appendChild(title);

      const subtitle = document.createElement('small');
      subtitle.textContent = '1 col mobile | 2 cols tablet | 3 cols desktop';
      innerDiv.appendChild(subtitle);

      col.appendChild(innerDiv);
      row.appendChild(col);
    }

    container.appendChild(row);
    return container;
  },
};
