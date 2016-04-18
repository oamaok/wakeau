import React from 'react';
import ReactDOM from 'react-dom';

const lerp = (a, b, x) => a * (1 - x) + b * x;

const lerpRGB = (a, b, x) =>[
  lerp(a[0], b[0], x),
  lerp(a[1], b[1], x),
  lerp(a[2], b[2], x),
];

const hexToRGBArray = color => color.match(/[a-f0-9]{2}/ig).map(hex => parseInt(hex, 16));

export default class BackgroundPlasma extends React.Component
{
  constructor (props) 
  {
    super(props);
    this.palette = this.props.palette.map(hexToRGBArray);
  }

  componentDidMount ()
  {
    this.context2d = this.refs.canvas.getContext("2d");

    // Fill the canvas once to reset the alpha channel to 255
    this.context2d.fillRect(0, 0, this.props.resolution[0], this.props.resolution[1]);
    let imageData = this.context2d.getImageData(0, 0, this.props.resolution[0], this.props.resolution[1]);
    let t = Math.random() * 100;
    let loop;

    (loop = () => {

      for(let x = 0; x < this.props.resolution[0]; x++) {
        for(let y = 0; y < this.props.resolution[1]; y++) {
          let index = (y * this.props.resolution[0] + x) * 4;
          let a = x * this.props.lod;
          let b = y * this.props.lod;
          let c = a + Math.sin(t / 3);
          let d = b + Math.cos(t / 2);

          // Magic.
          let v = (
            Math.sin(
              Math.sin(a + t)
              + Math.sin((b + t) * 0.5)
              + Math.sin((a + b * 2 + t) * 0.5)
              - Math.sin(Math.sqrt(c * c + d * d + 1) + t)
            ) + 1
          ) * 0.4999999;

          let paletteIndex = v * (this.palette.length - 1);
          let interp = paletteIndex % 1;
          let color = lerpRGB(this.palette[Math.floor(paletteIndex)], this.palette[Math.floor(paletteIndex) + 1], interp);

          imageData.data[index+0] = color[0];
          imageData.data[index+1] = color[1];
          imageData.data[index+2] = color[2];
        }
      }

      this.context2d.putImageData(imageData, 0, 0);
      t -= this.props.speed;

      window.requestAnimationFrame(loop);
    })();
  }

  render ()
  {
    return <canvas width={this.props.resolution[0]} height={this.props.resolution[1]} className="background-plasma" ref="canvas" />;
  }
}