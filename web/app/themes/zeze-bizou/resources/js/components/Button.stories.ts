import type { StoryObj, Meta } from '@storybook/html';
import { createButton } from './Button';

const meta: Meta = {
  title: 'Components/Button',
  render: (args) => {
    const button = createButton({
      text: args.text,
      variant: args.variant,
    });
    return button;
  },
  argTypes: {
    text: { control: 'text' },
    variant: {
      control: { type: 'select' },
      options: ['primary', 'secondary'],
    },
  },
};

export default meta;

type Story = StoryObj;

export const Primary: Story = {
  args: {
    text: 'Primary Button',
    variant: 'primary',
  },
};

export const Secondary: Story = {
  args: {
    text: 'Secondary Button',
    variant: 'secondary',
  },
};

export const Interactive: Story = {
  args: {
    text: 'Click Me!',
    variant: 'primary',
    onClick: () => {
      alert('Button clicked!');
    },
  },
};
