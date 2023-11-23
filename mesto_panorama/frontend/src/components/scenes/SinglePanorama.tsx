import {
  PerspectiveCamera,
  Environment,
  OrbitControls,
} from "@react-three/drei";
import { Canvas } from "@react-three/fiber";

const CabinetEnv = (props: { url: string[] | undefined }) => {
  const photos = props.url;
  return <Environment files={photos} background />;
};

const SinglePanorama = (props: { url: string[] | undefined }) => {
  const {
    url = [
      "/uploads/panorama/px.jpeg",
      "/uploads/panorama/nx.jpeg",
      "/uploads/panorama/py.jpeg",
      "/uploads/panorama/ny.jpeg",
      "/uploads/panorama/pz.jpeg",
      "/uploads/panorama/nz.jpeg",
    ],
  } = props;
  return (
    <Canvas camera={{ position: [100, 1, 1] }}>
      <CabinetEnv url={url} />
      <OrbitControls enableZoom={false} makeDefault target={[0, 1, 0]} />
      <PerspectiveCamera fov={60} position={[-4, 4, 4]} makeDefault />
    </Canvas>
  );
};

export default SinglePanorama;
