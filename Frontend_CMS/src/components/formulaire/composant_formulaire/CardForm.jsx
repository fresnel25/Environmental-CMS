import React from "react";

const CardForm = ({ children, title }) => {
  return (
    <div className="flex justify-center">
      <div className="card shadow bg-white w-220">
        <div className="card-body flex justify-center items-center">
          <h2 className="card-title">{title}</h2>
          <div className="mt-6">{children}</div>
          {/* <div className="card-actions justify-end">
            <button className="btn">Buy Now</button>
          </div> */}
        </div>
      </div>
      <div className="card "></div>
    </div>
  );
};

export default CardForm;
