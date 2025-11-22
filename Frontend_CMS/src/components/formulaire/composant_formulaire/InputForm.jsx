import React from "react";

const InputForm = ({ label, placeholder }) => {
  return (
    <div>
      <fieldset className="fieldset">
        <label className="label text-lg">{label}</label>
        <input type="text" className="input shadow-xl rounded-xl w-96" placeholder={placeholder} />
      </fieldset>
    </div>
  );
};

export default InputForm;
