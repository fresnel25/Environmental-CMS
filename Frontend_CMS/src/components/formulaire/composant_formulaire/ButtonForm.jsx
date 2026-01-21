const ButtonForm = ({title, onClick}) => {
  return (
    <div>
      <button type="submit" onClick={onClick} className="btn btn-soft btn-success">{title}</button>
    </div>
  );
};

export default ButtonForm;
