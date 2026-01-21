import React from "react";
import { ChromePicker } from "react-color";

const ChromePicker = () => {
  return (
    <div className="border rounded p-2 bg-base-100 w-fit">
      <div style={{ transform: "scale(0.85)", transformOrigin: "top left" }}>
        <ChromePicker
          color={currentColor}
          disableAlpha
          onChangeComplete={(color) => setCurrentColor(color.hex)}
        />
      </div>
    </div>
  );
};

export default ChromePicker;
